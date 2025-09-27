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
    $typ = $_POST['typ'];

    $conn->query("INSERT INTO pytania (quiz_id, tresc, typ) VALUES ('$quiz_id','$tresc','$typ')");
    $pytanie_id = $conn->insert_id;

    if($typ === "abcd"){
        for($i=1; $i<=4; $i++){
            $odp = $conn->real_escape_string($_POST["odp$i"]);
            $poprawna = isset($_POST["poprawna"]) && $_POST["poprawna"] == $i ? 1 : 0;
            $conn->query("INSERT INTO odpowiedzi (pytanie_id, tresc, poprawna) VALUES ('$pytanie_id','$odp','$poprawna')");
        }
    } else if($typ === "otwarte"){
        $poprawna_odp = $conn->real_escape_string($_POST["poprawna_otwarta"]);
        $conn->query("INSERT INTO odpowiedzi (pytanie_id, tresc, poprawna) VALUES ('$pytanie_id','$poprawna_odp',1)");
    }

    $conn->query("UPDATE quizy SET ilosc_pytan=ilosc_pytan+1 WHERE id='$quiz_id'");
    header("Location: dodaj_pytanie.php?id=$quiz_id");
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

    <label>Typ pytania:</label>
    <select name="typ" id="typ" onchange="toggleOdpowiedzi()">
        <option value="abcd">ABCD</option>
        <option value="otwarte">Otwarte</option>
    </select><br><br>

    <div id="odpowiedzi_abcd">
        <label>Odpowiedzi ABCD:</label><br>
        <?php for($i=1; $i<=4; $i++): ?>
            <input type="text" name="odp<?=$i?>" placeholder="Odpowiedź <?=$i?>">
            <input type="radio" name="poprawna" value="<?=$i?>"> Poprawna<br>
        <?php endfor; ?>
    </div>

    <div id="odpowiedzi_otwarte">
        <label>Poprawna odpowiedź (otwarte):</label><br>
        <input type="text" name="poprawna_otwarta" placeholder="Wpisz poprawną odpowiedź"><br>
    </div>

    <br>
    <input type="submit" name="submit" value="Dodaj pytanie">
</form>

<br>
<a href="index.php"><button>Powrót do strony głównej</button></a>

<script>
function toggleOdpowiedzi(){
    var typ = document.getElementById("typ").value;
    document.getElementById("odpowiedzi_abcd").style.display = (typ === "abcd") ? "block" : "none";
    document.getElementById("odpowiedzi_otwarte").style.display = (typ === "otwarte") ? "block" : "none";
}
toggleOdpowiedzi();
</script>
</body>
</html>
