<?php
session_start();
$conn = new mysqli("localhost", "root", "", "quizy");
$quiz_id = intval($_GET['id'] ?? 0);

$quiz = $conn->query("SELECT * FROM `quizy` WHERE `id` = '$quiz_id'")->fetch_assoc();
if (!$quiz) die("Nie znaleziono quizu.");

$pytania = $conn->query("SELECT * FROM `pytania` WHERE `quiz_id` = '$quiz_id'");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Quiz: <?=($quiz['nazwa'])?></title>
</head>
<body>
<h1><?=($quiz['nazwa'])?></h1>
<form action="wynik.php" method="post">
    <input type="hidden" name="quiz_id" value="<?=$quiz_id?>">
    <?php
    $i = 1;
    while ($pytanie = $pytania->fetch_assoc()) {
        echo "<h3>$i. ".($pytanie['tresc'])."</h3>";
        if ($pytanie['typ'] === "abcd") {
            $odp = $conn->query("SELECT * FROM `odpowiedzi` WHERE `pytanie_id`=".$pytanie['id']);
            while ($o = $odp->fetch_assoc()) {
                echo '<label><input type="radio" name="odp['.$pytanie['id'].']" value="'.$o['id'].'"> '.($o['tresc']).'</label><br>';
            }
        } else {
            echo '<input type="text" name="odp['.$pytanie['id'].']" placeholder="Twoja odpowiedź"><br>';
        }
        $i++;
    }
    ?>
    <br>
    <input type="submit" name="submit" value="Zakończ quiz">
</form>
</body>
</html>
