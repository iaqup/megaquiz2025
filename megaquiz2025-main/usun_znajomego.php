<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuń znajomego</title>
</head>
<body>
    <h1>Usuń znajomego</h1>
    <?php
    session_start();
    if(!isset($_SESSION['id'])) { 
    header("Location: logowanie.php"); 
    exit(); 
    }
    $conn = new mysqli("localhost","megaquiz","Megahaslo2.","megaquiz");
    $conn->set_charset("utf8mb4");
    $user_id = $_SESSION['id'];
    if (isset($_GET['id'])) {
        $usuwany = intval($_GET['id']);
        $conn->query("DELETE FROM `znajomi` WHERE (`id_nadawcy` = '$user_id' AND `id_odbiorcy` = '$usuwany') OR (`id_nadawcy` = '$usuwany' AND `id_odbiorcy` = '$user_id')");
    }
    $conn->close();
    header("Location: znajomi.php");
    exit();
    ?>
</body>
</html>