<?php
session_start();
if (isset($_SESSION['id'])) { 
    header("Location: index.php"); 
    exit(); 
}

$conn = new mysqli("localhost","megaquiz","Megahaslo2.","megaquiz");
$conn->set_charset("utf8mb4");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="rejestracja.css">
    <meta charset="UTF-8">
    <title>Rejestracja</title>
</head>
<body>
    <nav class="hotbar">
        <div class="left">
            <a href="index.php"><img src="logoo.png" alt="logo" width="60" height="50"></a>
        </div>
        <div class="right">
            Masz już konto? <a href="logowanie.php">Zaloguj się</a>
        </div>
    </nav>

    <h1>Zarejestruj się</h1>

    <form action="rejestracja.php" method="post">
        <input type="email" name="email" placeholder="Email" maxlength="60" required>
        <input name="user" placeholder="Nazwa użytkownika" minlength="6" maxlength="16" required>
        <input type="password" name="haslo" placeholder="Hasło" minlength="8" maxlength="16" required>
        <input type="password" name="haslo2" placeholder="Powtórz hasło" minlength="8" maxlength="16" required>
        <input type="submit" name="submit" value="Zarejestruj">
    </form>

<?php
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $users = trim($_POST['user']);
    $haslo = trim($_POST['haslo']);
    $haslo2 = trim($_POST['haslo2']);

    if (!empty($email) && !empty($users) && !empty($haslo) && !empty($haslo2)) {
        $check_user = $conn->query("SELECT id FROM `uzytkownicy` WHERE nazwa = '$users'");
        $check_email = $conn->query("SELECT id FROM `uzytkownicy` WHERE email = '$email'");

        if (!ctype_alnum($users)) {
            echo '<div style="color:red;text-align: center;">Nazwa użytkownika może zawierać tylko litery i cyfry.</div>';
        } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)[0-9A-Za-z!._@]{8,16}$/', $haslo)) {
            echo '<div style="color:red;text-align: center;">Hasło musi mieć 8–16 znaków, zawierać co najmniej jedną dużą literę i jedną cyfrę.<br>Dozwolone znaki: litery, cyfry, ! . _ @</div>';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<div style="color:red;text-align: center;">Nieprawidłowy adres e-mail!</div>';
        } elseif ($check_user->num_rows > 0) {
            echo '<div style="color:red;text-align: center;">Nazwa użytkownika jest już zajęta!</div>';
        } elseif ($check_email->num_rows > 0) {
            echo '<div style="color:red;text-align: center;">Ten e-mail jest już używany!</div>';
        } elseif ($haslo !== $haslo2) {
            echo '<div style="color:red;text-align:center;">Hasła muszą być takie same!</div>';
        } else {
            $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(32));

            $query = "INSERT INTO `uzytkownicy` (`nazwa`, `email`, `haslo`, `potwierdzony`, `token`)
                      VALUES ('$users', '$email', '$haslo_hash', 0, '$token')";

            if ($conn->query($query)) {
    
                $activation_link = "http://12348765.cba.pl/aktywuj.php?email=$email&token=$token";

                $subject = "Aktywacja konta - Quizy";
                $message = "Cześć $users!\n\nKliknij poniższy link, aby aktywować swoje konto:\n$activation_link\n\nPozdrawiamy,\nZespół Quizy";

                $headers = "From: kontakt@12348765.cba.pl\r\nReply-To: kontakt@12348765.cba.pl\r\nX-Mailer: PHP/" . phpversion();

                if (mail($email, $subject, $message, $headers)) {
                    echo '<div style="color:green;text-align:center;">Rejestracja przebiegła pomyślnie! Sprawdź swoją skrzynkę mailową i kliknij link aktywacyjny.</div>';
                } else {
                    echo "<div style='color:green;text-align:center;'>Rejestracja udana!<br>Kliknij, aby aktywować konto:<br><a href='$activation_link'>$activation_link</a></div>";
                }
            } else {
                echo '<div style="color:red;text-align:center;">Błąd serwera. Spróbuj ponownie.</div>';
            }
        }
    } else {
        echo '<div style="color:red;text-align:center;">Wypełnij wszystkie pola!</div>';
    }
}
?>
</body>
</html>
