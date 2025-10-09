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
    $conn = new mysqli("localhost","megaquiz","Megahaslo2.","megaquiz");    
    $user_id = $_SESSION['id'];
    if (isset($_GET['id'])) {
        $friend_id = $_GET['id'];
        $conn->query("DELETE FROM `znajomi` WHERE (`id_nadawcy` = '$user_id' AND `id_odbiorcy` = '$friend_id') OR (`id_nadawcy` = '$friend_id' AND `id_odbiorcy` = '$user_id')");
    }
    $conn->close();
    header("Location: znajomi.php");
    exit();
    ?>
</body>
</html>