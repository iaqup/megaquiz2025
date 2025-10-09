<?php
session_start();
if(!isset($_SESSION['id'])) {
    header("Location: logowanie.php");
    exit();
}
$conn = new mysqli("localhost","root","","quizy");
if($conn->connect_error) die("Błąd połączenia: " . $conn->connect_error);
$id = intval($_GET['id'] ?? 0);
$conn->query("DELETE FROM quizy WHERE id='$id' AND id_autor='".$_SESSION['id']."'");
header("Location: profil.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="logoo.png">
    <title>Usuwanie quizu</title>
</head>
<body>
    
</body>
</html>