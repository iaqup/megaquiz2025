<?php
session_start();
$conn = new mysqli("localhost","megaquiz","Megahaslo2.","megaquiz");
if($conn->connect_error) die("Błąd połączenia: " . $conn->connect_error);
$sort_options = [
    'date' => '`data_dodania` DESC',
    'questions' => '`ilosc_pytan` DESC',
    'category' => '`kategoria_id` ASC',
    'rating' => '`ocena_uz` DESC',
    'premium' => '`premium` DESC'
];

$sort = isset($_GET['sort']) && isset($sort_options[$_GET['sort']]) ? $_GET['sort'] : 'date';
$order_by = $sort_options[$sort];

$result = $conn->query("
    SELECT q.*, k.nazwa AS kategoria, u.nazwa AS autor
    FROM quizy q
    JOIN kategoria k ON q.kategoria_id = k.id
    JOIN uzytkownicy u ON q.id_autor = u.id WHERE q.id_autor = '".$_SESSION['id']."'
    ORDER BY $order_by
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="profil.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil użytkownika</title>
</head>
<body>
    <nav class="hotbar">
  <div class="left">
    <a href="index.php"><img src="logoo.png" alt="skibidi" width="60" height="50"></a>
  </div>
</nav>
    <h1>Twoje quizy:</h1>
    <form method="get" style="margin-bottom:10px;">
    <label for="sort">Sortuj według:</label>
    <select name="sort" id="sort" onchange="this.form.submit()">
        <option value="date" <?=($sort=='date'? 'selected':'')?>>Data dodania</option>
        <option value="questions" <?=($sort=='questions'? 'selected':'')?>>Ilość pytań</option>
        <option value="category" <?=($sort=='category'? 'selected':'')?>>Kategoria</option>
        <option value="rating" <?=($sort=='rating'? 'selected':'')?>>Ocena</option>
        <option value="premium" <?=($sort=='premium'? 'selected':'')?>>Premium</option>
    </select>
</form>
    <table>
    <tr>
        <th>Nazwa</th><th>Ilosc pytan</th><th>Data dodania</th><th>Ocena</th><th>Kategoria</th><th>Premium</th>
    </tr>
        <?php
        while ($row = $result->fetch_assoc()){
            $kategoria = $conn->query("SELECT nazwa FROM `kategoria` where id = ".$row['kategoria_id']);
            echo '<tr>';
            echo '<td>'.$row['nazwa'].'</td>';
            echo '<td>'.$row['ilosc_pytan'].'</td>';
            echo '<td>'.$row['data_dodania'].'</td>';
            echo '<td>'.$row['ocena_uz'].'</td>';
            echo '<td>'.$kategoria->fetch_assoc()['nazwa'].'</td>';
            echo '<td>'.($row['premium'] ? 'Tak' : 'Nie').'</td>';
            echo '<td><a href="usun_quiz.php?id='.$row['id'].'" onclick="return confirm(\'Czy na pewno chcesz usunąć ten quiz?\')"><button>Usuń quiz</button></a></td>';
            echo '</tr>';
        }
        ?>
    </table>
    <a href="index.php">
    <button>Strona główna</button>
    </a>
</body>
</html>

