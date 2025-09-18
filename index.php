<?php 
session_start();
$conn = new mysqli("localhost","root","","quizy");
$result = $conn->query("SELECT * FROM `quizy`");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mega Quizy - Strona główna</title>
</head>
<body>
    <?php if (isset($_SESSION['user'])){?>
        Witaj, <?=$_SESSION['user']?>
        <a href="wyloguj.php">
        <button>Wyloguj się</button> 
        </a>
    <?php } 
    else { ?>
        <a href="logowanie.php">
    <button>Zaloguj się</button> 
    </a>
    <a href="rejestracja.php">
    <button>Zarejestruj się</button> 
    </a>
    <?php
    }
    ?>
    
    <table>
    <tr>
        <td>nazwa</td><td>data dodania</td><td>ocena</td><td>kategoria</td><td>premium</td></tr>
        <?php 
        while ($row = $result->fetch_assoc()){
            $nazwa = $row['nazwa'];
            $data_dod = $row['data_dodania'];
            $ocena = $row['ocena_uz'];
            $premium = $row['premium'] ? 'tak':'nie';
            $kategoria = $row['kategoria_id'];
            ?>
            <tr><td><?=$nazwa?></td><td><?=$data_dod?></td><td><?=$ocena?></td><td><?=$kategoria?></td><td><?=$premium?></td><?php
            var_dump($_SESSION);
        } 
    ?></table>
    
</body>
</html>