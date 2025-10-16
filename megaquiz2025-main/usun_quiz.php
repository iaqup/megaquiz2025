<?php
session_start();
if(!isset($_SESSION['id'])) {
    header("Location: logowanie.php");
    exit();
}
$conn = new mysqli("localhost","megaquiz","Megahaslo2.","megaquiz");
$conn->set_charset("utf8mb4");
if($conn->connect_error) die("Błąd połączenia: " . $conn->connect_error);
$id = intval($_GET['id'] ?? 0);
$user_id = intval($_SESSION['id']);
$conn->query("DELETE FROM quizy WHERE id=$id AND id_autor=$user_id");
$conn->close();
header("Location: profil.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuwanie quizu</title>
</head>
<body>
    
</body>
</html>