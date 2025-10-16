<?php
session_start();
$conn = new mysqli("localhost","megaquiz","Megahaslo2.","megaquiz");
$conn->set_charset("utf8mb4");
$user_id = intval($_GET['id'] ?? 0);
if(!isset($_SESSION['id'])) { 
    header("Location: logowanie.php"); 
    exit(); 
}
if (isset($_POST['potwierdz'])) {
    $conn->query("UPDATE `uzytkownicy` SET `potwierdzony` = 1 WHERE `id` = '$user_id'");
    $conn->close();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Potwierdź znajomość</title>
</head>
<body>
</body>
</html>
