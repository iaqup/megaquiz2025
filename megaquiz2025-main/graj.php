<?php
session_start();
$conn = new mysqli("localhost", "root", "", "quizy");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Quiz: <?=($quiz['nazwa'])?></title>
</head>
<body>
<h1><?=($quiz['nazwa'])?></h1>
<div>Poprawne odpowiedzi: <?=$_SESSION['poprawne']?> / <?=$_SESSION['pytanie']?><br>Pozostało: <?=intval($_SESSION['suma_pytan'])-intval($_SESSION['pytanie'])?></div>
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
</body>
</html>
