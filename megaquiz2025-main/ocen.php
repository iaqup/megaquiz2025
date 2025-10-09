<?php
session_start();
$conn = new mysqli("localhost","root","","quizy");

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['id'];

$quiz_id = isset($_POST['quiz_id']) ? intval($_POST['quiz_id']) : 0;
$ocena = isset($_POST['ocena']) ? intval($_POST['ocena']) : 0;

if ($quiz_id > 0 && $ocena >= 1 && $ocena <= 5) {
    $conn->query("INSERT INTO `oceny` (`quiz_id`, `uzytkownik_id`, `ocena`) VALUES ('$quiz_id','$user_id','$ocena')");

    $stat = $conn->query("SELECT AVG(ocena) as sr, COUNT(*) as ile FROM `oceny` WHERE `quiz_id`='$quiz_id'")->fetch_assoc();
    $sr = round($stat['sr'], 1);
    $ile = $stat['ile'];

    $conn->query("UPDATE `quizy` SET `ocena_uz`='$sr', `ilosc_ocen`='$ile' WHERE `id`='$quiz_id'");
}

header("Location: graj.php?id=$quiz_id");
exit();
?>
