<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil użytkownika</title>
</head>
<body>
    <h1>Twoje quizy:</h1>
    <table>
    <tr>
        <th>Nazwa</th><th>Ilosc pytan</th><th>Data dodania</th><th>Ocena</th><th>Kategoria</th><th>Premium</th>
    </tr>
        <?php
        session_start();
        $conn = new mysqli("localhost","root","","quizy");
        $user_id = $_SESSION['id'];
        $result = $conn->query("SELECT * FROM `quizy` WHERE `id_autor` = '$user_id'");
        
        while ($row = $result->fetch_assoc()){
            $kategoria = $conn->query("SELECT nazwa FROM `kategoria` where id = ".$row['kategoria_id']);
            echo '<tr>';
            echo '<td>'.$row['nazwa'].'</td>';
            echo '<td>'.$row['ilosc_pytan'].'</td>';
            echo '<td>'.$row['data_dodania'].'</td>';
            echo '<td>'.$row['ocena_uz'].'</td>';
            echo '<td>'.$kategoria->fetch_assoc()['nazwa'].'</td>';
            echo '<td>'.($row['premium'] ? 'Tak' : 'Nie').'</td>';
            echo '</tr>';
        }
        ?>
    </table>
    <a href="index.php">
    <button>Strona główna</button>
    </a>
</body>
</html>