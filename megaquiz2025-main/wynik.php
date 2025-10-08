<?php
session_start();
$conn = new mysqli("localhost", "root", "", "quizy");

if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

$user_id = $_SESSION['id'] ?? null;
$quiz_id = intval($_POST['quiz_id'] ?? $_GET['quiz_id'] ?? 0);
if ($quiz_id <= 0) {
    die("Nieprawidłowy identyfikator quizu.");
}

$odpowiedzi = $_POST['odp'] ?? [];

$pytania = $conn->query("SELECT * FROM pytania WHERE quiz_id='$quiz_id'");
if (!$pytania || $pytania->num_rows == 0) {
    die("Nie znaleziono pytań dla tego quizu.");
}

$punkty = 0;
$wszystkie = $pytania->num_rows;

while ($pytanie = $pytania->fetch_assoc()) {
    if ($pytanie['typ'] === "abcd") {
        $poprawna = $conn->query("SELECT id FROM odpowiedzi WHERE pytanie_id=" . $pytanie['id'] . " AND poprawna=1")->fetch_assoc();
        if (isset($odpowiedzi[$pytanie['id']]) && $odpowiedzi[$pytanie['id']] == $poprawna['id']) {
            $punkty++;
        }
    } elseif ($pytanie['typ'] === "otwarte") {
        $poprawna = $conn->query("SELECT tresc FROM odpowiedzi WHERE pytanie_id=" . $pytanie['id'] . " AND poprawna=1")->fetch_assoc();
        if (isset($odpowiedzi[$pytanie['id']]) && trim(strtolower($odpowiedzi[$pytanie['id']])) === trim(strtolower($poprawna['tresc']))) {
            $punkty++;
        }
    }
}

$niepoprawne = $wszystkie - $punkty;
$procent = $wszystkie > 0 ? round(($punkty / $wszystkie) * 100, 1) : 0;

$komunikat = "";

if ($user_id && isset($_POST['ocena'])) {
    $ocena = filter_var($_POST['ocena'], FILTER_VALIDATE_INT, [
        "options" => ["min_range" => 1, "max_range" => 5]
    ]);

    if ($ocena !== false) {
        $conn->query("INSERT INTO oceny (quiz_id, uzytkownik_id, ocena) VALUES ('$quiz_id', '$user_id', '$ocena')");

        $stat = $conn->query("SELECT AVG(ocena) AS sr, COUNT(*) AS ile FROM oceny WHERE quiz_id='$quiz_id'")->fetch_assoc();
        $sr = round($stat['sr'], 1);
        $ile = $stat['ile'];
        $conn->query("UPDATE quizy SET ocena_uz='$sr', ilosc_ocen='$ile' WHERE id='$quiz_id'");

        $komunikat = "Dziękujemy! Twoja ocena została zapisana.";
    } else {
        $komunikat = "Ocena musi być liczbą całkowitą w zakresie od 1 do 5.";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wynik quizu</title>
</head>
<body>

    <h1>Twój wynik: <?= $punkty ?> / <?= $wszystkie ?></h1>

    <div class="statystyki">
        <h2>Statystyki quizu</h2>
        <p>Poprawne odpowiedzi: <b><?= $punkty ?></b></p>
        <p>Błędne odpowiedzi: <b><?= $niepoprawne ?></b></p>
        <p>Skuteczność: <b><?= $procent ?>%</b></p>
    </div>

    <?php if ($user_id): ?>
        <form action="wynik.php" method="post">
            <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
            <label>Oceń quiz (1–5):</label>
            <input type="number" name="ocena" min="1" max="5" required>
            <input type="submit" value="Oceń">
        </form>

        <?php if ($komunikat): ?>
            <p class="msg"><?= htmlspecialchars($komunikat) ?></p>
        <?php endif; ?>
    <?php else: ?>
        <p>Aby ocenić quiz, musisz być zalogowany.</p>
    <?php endif; ?>

    <br>
    <a href="index.php"><button>Powrót do strony głównej</button></a>

</body>
</html>
