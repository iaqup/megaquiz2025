<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odrzuć zaproszenie</title>
</head>
<body>
    <?php
    session_start();
    $conn = new mysqli("localhost","megaquiz","Megahaslo2.","megaquiz");
    $conn->set_charset("utf8mb4");
    $user_id = $_SESSION['id'];
    if (isset($_GET['id'])) {
        $x = intval($_GET['id']);
        $conn->query("DELETE FROM `znajomi` WHERE `id_nadawcy` = '$x' AND `id_odbiorcy` = '$user_id'");
        $conn->close();
        header("Location: znajomi.php");
        exit();
    }
    else { 
    header("Location: logowanie.php"); 
    exit(); 
}
    ?>
</body>
</html>