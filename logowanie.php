<?php
session_start();
$conn = new mysqli("localhost","root","","quizy");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
</head>
<body>
    <form action="logowanie.php" method="post">
            <input name="user" placeholder="email / nazwa użytkownika" minlength="6" maxlength="60">
            <input name="haslo" placeholder="hasło" minlength="8" maxlength="16">
            <input type="submit" name="submit">
        </form>
        <?php
        if (isset($_POST['submit'])){
            if (isset($_POST['user']) and isset($_POST['haslo'])){
                $user = $_POST['user'];
                $haslo = $_POST['haslo'];
                if (str_contains($user,'@')){
                    $result = $conn->query("SELECT * FROM `uzytkownicy` WHERE `email` = '$user' and `haslo` = '$haslo'");
                }
                else{
                    $result = $conn->query("SELECT * FROM `uzytkownicy` WHERE `nazwa` = '$user' and `haslo` = '$haslo'");
                }
                if ($result->num_rows > 0){
                    $result = $result->fetch_assoc();
                    var_dump($result);
                    if ($result['potwierdzony'] == 0){
                        $_SESSION['user'] = $result['nazwa'];
                        $_SESSION['email'] = $result['email'];
                        $_SESSION['admin'] = $result['admin'];
                        header("Location: index.php");
                    }
                    else{
                        echo "Konto nie zostało potwierdzone";
                    }

                }
                else{
                    // coś co poinformuje że błędne dane
                }
                
                $conn->close();
        }
        }
        ?>
    
</body>
</html>