<?php
session_start();
if(!isset($_SESSION['id'])) { 
    header("Location: logowanie.php"); 
    exit(); 
}

$conn = new mysqli("localhost","megaquiz","Megahaslo2.","megaquiz");
if($conn->connect_error) 
    die("Błąd połączenia: " . $conn->connect_error);

$quiz_id = intval($_GET['id'] ?? 0);
$quiz = $conn->query("SELECT * FROM quizy WHERE id=$quiz_id")->fetch_assoc();
if(!$quiz) die("Nie znaleziono quizu");

$count = $conn->query("SELECT COUNT(*) AS c FROM pytania WHERE quiz_id=$quiz_id")->fetch_assoc()['c'];
$error = '';

if(isset($_POST['finish'])){
    $conn->query("UPDATE quizy SET ilosc_pytan = (SELECT COUNT(*) FROM pytania WHERE quiz_id=$quiz_id) WHERE id=$quiz_id");
    echo "<p>Quiz utworzony! Wracamy na stronę główną...</p>";
    echo "<script>setTimeout(()=>{ window.location='index.php'; }, 800);</script>";
    exit();
}

if(isset($_POST['submit'])){
    $tresc = trim($_POST['tresc']);
    if($tresc === '') $error = "Treść pytania nie może być pusta.";

    if(!$error){
        $conn->query("INSERT INTO pytania (quiz_id, tresc, typ, kolejnosc) 
                      VALUES ('$quiz_id', '$tresc', 'abcd', ".($count+1).")");
        $pytanie_id = $conn->insert_id;

        for($i=1; $i<=4; $i++){
            $odp = trim($_POST["odp$i"]);
            if($odp !== ''){
                $poprawna = (isset($_POST['poprawna']) && $_POST['poprawna']==$i) ? 1 : 0;
                $conn->query("INSERT INTO odpowiedzi (pytanie_id, tresc, poprawna, kolejnosc) 
                              VALUES ('$pytanie_id','$odp','$poprawna','$i')");
            }
        }

        $conn->query("UPDATE quizy SET ilosc_pytan = ilosc_pytan + 1 WHERE id=$quiz_id");

        header("Location: dodaj_pytanie.php?id=$quiz_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Dodaj pytanie do quizu</title>
</head>
<body>
<h1>Quiz: <?=htmlspecialchars($quiz['nazwa'])?></h1>
<p>Aktualna liczba pytań: <?=$count?></p>

<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post">
    <label>Treść pytania:</label><br>
    <textarea name="tresc" required></textarea><br><br>

    <div>
        <?php for($i=1;$i<=4;$i++): ?>
            <input type="text" name="odp<?=$i?>" placeholder="Odpowiedź <?=$i?>" required>
            <input type="radio" name="poprawna" value="<?=$i?>" required> Poprawna<br>
        <?php endfor; ?>
    </div>

    <input type="submit" name="submit" value="Dodaj kolejne pytanie">
    <input type="submit" name="finish" value="Zakończ tworzenie">
</form>
</body>
</html>