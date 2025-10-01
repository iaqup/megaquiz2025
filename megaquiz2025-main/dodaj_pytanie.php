<?php
session_start();
if(!isset($_SESSION['id'])) {
    header("Location: logowanie.php");
    exit();
}

$conn = new mysqli("localhost","root","","quizy");
if($conn->connect_error) die("Błąd połączenia: " . $conn->connect_error);

$quiz_id = intval($_GET['id'] ?? 0);
$quiz = $conn->query("SELECT * FROM quizy WHERE id='$quiz_id'")->fetch_assoc();
if(!$quiz) die("Nie znaleziono quizu");

if(isset($_POST['submit'])){
    $tresc = $conn->real_escape_string($_POST['tresc']);
    $pytanie = $_GET['pytanie'];
    $pyt1 = $_POST['odp1'];
    $pyt2 = $_POST['odp2'];
    $pyt3 = $_POST['odp3'];
    $pyt4 = $_POST['odp4'];
    $popr = $_POST['poprawna'];    
    $conn->query("INSERT INTO `pytania`(`id`, `tresc`, `A`, `B`, `C`, `D`, `poprawne`) VALUES (NULL,$tresc,$pyt1,$pyt2,$pyt3,$pyt4,$popr);");
    $pytanie_id = $conn->insert_id;
    $conn->query("INSERT INTO `quizy-pytania`(`id_quiz`, `id_pytanie`) VALUES ($quiz_id,$pytanie_id);");
    $conn->query("UPDATE quizy SET ilosc_pytan=$pytanie WHERE id='$quiz_id'");
    $pytanie++;
    header("Location: dodaj_pytanie.php?id=$quiz_id&pytanie=$pytanie");
    exit();
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

<form method="post">
    <label>Treść pytania:</label><br>
    <textarea name="tresc" required></textarea><br><br>
        <?php for($i=1; $i<=4; $i++): ?>
            <input type="text" name="odp<?=$i?>" placeholder="Odpowiedź <?=$i?>">
            <input type="radio" name="poprawna" value="<?=$i?>"> Poprawna<br>
        <?php endfor; ?>
    <br>
    <input type="submit" name="submit" value="Dodaj pytanie">
</form>

<br>
<a href="index.php"><button>Zakończ tworzenie</button></a>

</body>
</html>
