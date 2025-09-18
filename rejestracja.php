<?php 
$conn = new mysqli("localhost","root","","quizy");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
</head>
<link rel="stylesheet" href= "rejestracja.css">
<body>
    Zarejestruj się
    <form action="rejestracja.php" method="post">
            <input type="email" name="email" placeholder="email" maxlength="60">
            <input name="user" placeholder="nazwa użytkownika" minlength="6" maxlength="16">
            <input type="password" name="haslo" placeholder="hasło" minlength="8" maxlength="16">
            <input type="submit" name="submit">
    </form>
    <?php 
        if (isset($_POST['submit'])){
    if (!empty($_POST['email']) && !empty($_POST['user']) && !empty($_POST['haslo'])) {
                $email = $_POST['email'];
                $users = $_POST['user'];
                $haslo = $_POST['haslo'];
                $conn->query("INSERT INTO `uzytkownicy` (`id`, `nazwa`, `email`, `haslo`) VALUES (NULL, '$users', '$email', '$haslo')");
                $conn->close();
                
                }}

            else{
                //coś co poinformuje że nie wprowadzono
                
            }
    ?>
</body>
</html>