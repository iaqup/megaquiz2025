<?php
session_start();
$conn = new mysqli("localhost","root","", "quizy");

$user_id = intval($_GET['id'] ?? 0);

if (isset($_POST['potwierdz'])) {
    $conn->query("UPDATE `uzytkownicy` SET `potwierdzony` = 1 WHERE `id` = '$user_id'");
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Potwierdź konto</title>
    <link rel="icon" type="image/x-icon" href="logoo.png">
</head>
<body>
    <h1>Dziękujemy za rejestrację!</h1>
    <p>Kliknij przycisk, aby potwierdzić konto i przejść do strony głównej.</p>
    <form method="post">
        <input type="submit" name="potwierdz" value="Potwierdź konto">
    </form>
</body>
</html>
