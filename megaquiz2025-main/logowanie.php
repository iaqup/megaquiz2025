<?php
session_start();

$conn = new mysqli("localhost", "root", "", "quizy");
if ($conn->connect_error) {
    die("Błąd połączenia z bazą: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4"); 

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="logowanie.css">
    <meta charset="UTF-8">
    <title>Logowanie</title>
</head>
<body>
        <nav class="hotbar">
  <div class="left">
    <a href="index.php"><a href="index.php"><img src="logoo.png" alt="skibidi" width="60" height="50"></a></a>
  </div>
  <div class="right">
    <a href="rejestracja.php">Zarejestruj się</a>
  </div>
</nav>
    <h1>Zaloguj się</h1>
    <form action="logowanie.php" method="post">
        <input name="user" placeholder="Email / nazwa użytkownika" minlength="6" maxlength="60" required>
        <input type="password" name="haslo" placeholder="Hasło" minlength="8" maxlength="16" required>
        <input type="submit" name="submit" value="Zaloguj">
    </form>

<?php
if (isset($_POST['submit'])) {
    $user = trim($_POST['user']);
    $haslo = $_POST['haslo'];

    if (str_contains($user, '@')) {
        $stmt = $conn->prepare("SELECT * FROM `uzytkownicy` WHERE `email` = ?");
    } else {
        $stmt = $conn->prepare("SELECT * FROM `uzytkownicy` WHERE `nazwa` = ?");
    }
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($haslo, $row['haslo'])) {
            if ($row['potwierdzony'] == '1') {
                $_SESSION['user'] = $row['nazwa'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['admin'] = $row['admin'] ?? 0;
                $_SESSION['id'] = $row['id'];

                header("Location: index.php");
                exit();
            } else {
                echo '<div style="color:red;">Konto nie zostało potwierdzone!</div>';
            }
        } else {
            echo '<div style="color:red;">❌ Błędne hasło!</div>';
        }
    } else {
        echo '<div style="color:red;">Nie znaleziono użytkownika!</div>';
    }

    $stmt->close();
}
$conn->close();
?>
</body>
</html>
