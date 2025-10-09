<?php 
$conn = new mysqli("localhost","root","","quizy");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="rejestracja.css">
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="logoo.png">
    <title>Rejestracja</title>
</head>
<body>
    <nav class="hotbar">
  <div class="left">
    <a href="index.php">  <a href="index.php"><img src="logoo.png" alt="skibidi" width="60" height="50"></a></a>
  </div>
  <div class="right">
    <a href="logowanie.php">Zaloguj się</a>
  </div>
    </nav>
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
            $check_user = $conn->query("SELECT id FROM `uzytkownicy` WHERE nazwa = '$users'");
            $check_email = $conn->query("SELECT id FROM `uzytkownicy` WHERE email = '$email'");
            if (!ctype_alnum($users)) {
                echo '<div style="color:red;">Nazwa użytkownika nie spełnia wymagań, dozwolone są wyłącznie litery oraz cyfry.</div>';
            }
            else if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!._@]{8,16}$/', $haslo)) {
                echo '<div style="color:red;">Hasło nie spełnia wymagań; dozwolone są wyłącznie litery, cyfry oraz znaki specjalne !  .  _  @</div>';
            }
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo '<div style="color:red;">Nieprawidłowy mail!</div>';
            }
            else if ($check_user->num_rows > 0) {
                echo '<div style="color:red;">Nazwa użytkownika jest zajęta!</div>';
            }
            else if ($check_email->num_rows > 0) {
                echo '<div style="color:red;">Istnieje już konto powiązane z tym mailem!</div>';
            }

            else if($haslo == $haslo2){
                
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
    Masz już konto? <a href="logowanie.php">Zaloguj się</a>
</body>
</html>



