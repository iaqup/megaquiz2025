<?php
$conn = new mysqli("localhost","megaquiz","Megahaslo2.","megaquiz");
$conn->set_charset("utf8mb4");

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $conn->real_escape_string($_GET['email']);
    $token = $conn->real_escape_string($_GET['token']);

    $result = $conn->query("SELECT id FROM uzytkownicy WHERE email='$email' AND token='$token' AND potwierdzony=0");

    if ($result && $result->num_rows > 0) {
        $conn->query("UPDATE uzytkownicy SET potwierdzony=1, token=NULL WHERE email='$email'");
        echo "<h2>Konto zostało pomyślnie aktywowane! Możesz się teraz <a href='logowanie.php'>zalogować</a>.</h2>";
    } else {
        echo "<h2>Nieprawidłowy lub już użyty link aktywacyjny.</h2>";
    }
} else {
    echo "<h2>Nieprawidłowe zapytanie.</h2>";
}

$conn->close();
?>
