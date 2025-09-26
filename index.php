<?php 
session_start();
$conn = new mysqli("localhost","root","","quizy");
$result = $conn->query("SELECT * FROM `quizy`");

$sort_options = [
    'date' => '`data_dodania` DESC',
    'questions' => '`ilosc_pytan` DESC',
    'category' => '`kategoria_id` ASC',
    'rating' => '`ocena_uz` DESC',
    'premium' => '`premium` DESC'
];
$sort = isset($_GET['sort']) && isset($sort_options[$_GET['sort']]) ? $_GET['sort'] : 'date';
$order_by = $sort_options[$sort];
$result = $conn->query("SELECT * FROM `quizy` ORDER BY $order_by");
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
        <a href="profil.php">
        <button>Moje quizy</button>
        </a>
        <a href="znajomi.php">
        <button>Znajomi</button>
        </a>
        <?php if ($_SESSION['admin'] == '1'){ ?>
            <a href="admin.php">
            <button>Panel admina</button>
            </a>
    <?php }} 
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
            <td>nazwa</td><td>data dodania</td><td>ocena</td><td>kategoria</td><td>premium</td></tr>
        <?php 
        while ($row = $result->fetch_assoc()){
            $nazwa = $row['nazwa'];
            $data_dod = $row['data_dodania'];
            $ocena = $row['ocena_uz'];
            $premium = $row['premium'] ? 'tak':'nie';
            $kategoria = $row['kategoria_id'];
            ?>
            <tr><td><?=$nazwa?></td><td><?=$data_dod?></td><td><?=$ocena?></td><td><?=$kategoria?></td><td><?=$premium?></td></tr>
            <?php
        } 
    ?></table>
    
</body>
</html>