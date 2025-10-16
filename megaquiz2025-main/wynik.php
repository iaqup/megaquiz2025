<?php
session_start();
$time = microtime(true) - ($_SESSION['czas'] ?? $startTime);
$conn = new mysqli("localhost","megaquiz","Megahaslo2.","megaquiz");

if($conn->connect_error) die("Błąd połączenia: " . $conn->connect_error);

$user_id = $_SESSION['id'] ?? null;
$quiz_id = intval($_POST['quiz_id'] ?? 0);
$odpowiedzi = $_POST['odp'] ?? [];

$pytania = $conn->query("SELECT * FROM pytania WHERE quiz_id='$quiz_id'");
if(!$pytania) die("Nie znaleziono pytań");

$punkty = 0;
$wszystkie = $pytania->num_rows;

while ($pytanie = $pytania->fetch_assoc()) {
    if ($pytanie['typ'] === "abcd") {
        $poprawna = $conn->query("SELECT id FROM odpowiedzi WHERE pytanie_id=".$pytanie['id']." AND poprawna=1")->fetch_assoc();
        if (isset($odpowiedzi[$pytanie['id']]) && $odpowiedzi[$pytanie['id']] == $poprawna['id']) {
            $punkty++;
        }
    } else if ($pytanie['typ'] === "otwarte") {
        $poprawna = $conn->query("SELECT tresc FROM odpowiedzi WHERE pytanie_id=".$pytanie['id']." AND poprawna=1")->fetch_assoc();
        if (isset($odpowiedzi[$pytanie['id']]) && trim(strtolower($odpowiedzi[$pytanie['id']])) === trim(strtolower($poprawna['tresc']))) {
            $punkty++;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Wynik quizu</title>
<link rel="stylesheet" href="wynik.css">
</head>
<body>
<h1>Twój wynik: <?= $punkty ?> / <?= $wszystkie ?><br> Czas: <?= round($time, 2) ?> s</h1>

<?php if($user_id): ?>
    <form action="ocen.php" method="post">
        <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
        <label>Oceń quiz (1-5):</label>
        <input type="number" name="ocena" min="1" max="5" required>
        <input type="submit" name="submit" value="Oceń">
    </form>
<?php else: ?>
    <p>Aby ocenić quiz, musisz być zalogowany.</p>
<?php endif; ?>

<br>
<a href="index.php"><button>Powrót do strony głównej</button></a>
</body>
</html>
