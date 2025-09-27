<?php
session_start();
$conn = new mysqli("localhost", "root", "", "quizy");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
</head>
<body>
    <h1>Zaloguj się</h1>
    <form action="logowanie.php" method="post">
        <input name="user" placeholder="Email / nazwa użytkownika" minlength="6" maxlength="60" required>
        <input name="haslo" placeholder="Hasło" minlength="8" maxlength="16" required>
        <input type="submit" name="submit" value="Zaloguj">
    </form>

    <?php
    if (isset($_POST['submit'])){
        $user = $_POST['user'];
        $haslo = $_POST['haslo'];

        if (str_contains($user,'@')){
            $result = $conn->query("SELECT * FROM `uzytkownicy` WHERE `email` = '$user' and `haslo` = '$haslo'");
        } else {
            $result = $conn->query("SELECT * FROM `uzytkownicy` WHERE `nazwa` = '$user' and `haslo` = '$haslo'");
        }

        if ($result->num_rows > 0){
            $result = $result->fetch_assoc();
            if ($result['potwierdzony'] == '1'){
                $_SESSION['user'] = $result['nazwa'];
                $_SESSION['email'] = $result['email'];
                $_SESSION['admin'] = $result['admin'] ?? 0;
                $_SESSION['id'] = $result['id'];
                header("Location: index.php");
                exit();
            } else {
                echo "Konto nie zostało potwierdzone!";
            }
        } else {
            echo '<div style="color:red;">Błędny login lub hasło!</div>';
        }
        $conn->close();
    }
    ?>
</body>
</html>
