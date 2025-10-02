<?php 
$conn = new mysqli("localhost","root","","quizy");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
</head>
<body>
    <h1>Zarejestruj się</h1>
    <form action="rejestracja.php" method="post">
        <input type="email" name="email" placeholder="Email" maxlength="60" required>
        <input name="user" placeholder="Nazwa użytkownika" minlength="6" maxlength="16" required>
        <input type="password" name="haslo" placeholder="Hasło" minlength="8" maxlength="16" required>
        <input type="password" name="haslo2" placeholder="Powtorz Hasło" minlength="8" maxlength="16" required>
        <input type="submit" name="submit" value="Zarejestruj">
    </form>

    <?php 
    if (isset($_POST['submit'])){
        $email = $_POST['email'];
        $users = $_POST['user'];
        $haslo = $_POST['haslo'];
        $haslo2 = $_POST['haslo2'];

        if (!empty($email) && !empty($users) && !empty($haslo) && !empty($haslo2)) {

            if($haslo == $haslo2){
                $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
                $conn->query("INSERT INTO `uzytkownicy` (`id`, `nazwa`, `email`, `haslo`, `potwierdzony`) VALUES (NULL, '$users', '$email', '$haslo_hash', 1)");
                $user_id = $conn->insert_id;
                $conn->close();

                session_start();
                $_SESSION['user'] = $users;
                $_SESSION['email'] = $email;
                $_SESSION['id'] = $user_id;
                $_SESSION['admin'] = 0;

                header("Location: index.php");
                exit();
            } else{
                echo '<div style="color:red;">Hasła muszą być takie same!</div>';
            }
        } else {
            echo '<div style="color:red;">Wypełnij wszystkie pola!</div>';
        }
    }
    ?>
</body>
</html>
