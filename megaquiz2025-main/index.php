<?php
session_start();
$conn = new mysqli("localhost","root","","quizy");

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
    JOIN uzytkownicy u ON q.id_autor = u.id
    ORDER BY $order_by LIMIT 10
");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8">
    <title>Mega Quizy - Strona główna</title>
</head>
<body>
    <nav class= "hotbar">
        <div class="left">
    <a href="index.php">  <a href="index.php"><img src="logoo.png" alt="skibidi" width="60" height="50"></a></a>
  </div>
        <div>
<?php if(isset($_SESSION['user'])): ?>
    Witaj, <?=($_SESSION['user'])?>
    <a href="wyloguj.php"><button>Wyloguj się</button></a>
    <a href="profil.php"><button>Moje quizy</button></a>
    <a href="znajomi.php"><button>Znajomi</button></a>
    <?php if($_SESSION['admin'] == '1'): ?>
        <a href="admin.php"><button>Panel admina</button></a>
    <?php endif; ?>
    <a href="dodaj_quiz.php"><button>Utwórz nowy quiz</button></a>
<?php else: ?>
    <a href="logowanie.php"><button>Zaloguj się</button></a>
    <a href="rejestracja.php"><button>Zarejestruj się</button></a>
<?php endif; ?>
</div>
</nav>

<h1>Lista quizów</h1>
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

<table border="1" cellpadding="5">
<tr>
    <th>Nazwa</th><th>Autor</th><th>Data dodania</th><th>Ilość pytań</th><th>Ocena</th><th>Kategoria</th><th>Premium</th>
</tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <tr onclick="window.location='graj.php?id=<?= $row['id'] ?>'" style="cursor:pointer;">
    <td><?= $row['nazwa'] ?></td>
    <td><?= $row['autor'] ?></td>
    <td><?= $row['data_dodania'] ?></td>
    <td><?= $row['ilosc_pytan'] ?></td>
    <td><?= $row['ocena_uz'] ?></td>
    <td><?= $row['kategoria'] ?></td>
    <td><?= $row['premium'] ? 'tak' : 'nie' ?></td>
</tr>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>


