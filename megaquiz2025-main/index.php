<?php
session_start();
$conn = new mysqli("localhost","megaquiz","Megahaslo2.","megaquiz");
$conn->set_charset("utf8mb4");
if ($conn->connect_error) {
    die('Connection error: ' . $conn->connect_error);
}
$sort_options = [
    'date' => '`data_dodania` DESC',
    'questions' => '`ilosc_pytan` DESC',
    'category' => '`kategoria_id` ASC',
    'rating' => '`ocena_uz` DESC',
    'premium' => '`premium` DESC'
];
$kategorie = [];
$kategoriequery = $conn->query("SELECT id, nazwa FROM kategoria ORDER BY nazwa ASC");
    while ($c = $kategoriequery->fetch_assoc()) {
        $kategorie[] = $c;
    }
$szukanie = [];
$data_od = isset($_GET['data_od']) ? trim($_GET['data_od']) : '';
$data_do = isset($_GET['data_do']) ? trim($_GET['data_do']) : '';
if ($data_od !== '') {
    $df = $conn->real_escape_string($data_od);
    $szukanie[] = "DATE(q.data_dodania) >= '$df'";
}
if ($data_do !== '') {
    $dt = $conn->real_escape_string($data_do);
    $szukanie[] = "DATE(q.data_dodania) <= '$dt'";
}

$pytania_od = isset($_GET['pytania_od']) && $_GET['pytania_od'] !== '' ? intval($_GET['pytania_od']) : '';
$pytania_do = isset($_GET['pytania_do']) && $_GET['pytania_do'] !== '' ? intval($_GET['pytania_do']) : '';
if ($pytania_od !== '') {
    $szukanie[] = "q.ilosc_pytan >= $pytania_od";
}
if ($pytania_do !== '') {
    $szukanie[] = "q.ilosc_pytan <= $pytania_do";
}

$ocena_od = isset($_GET['ocena_od']) && $_GET['ocena_od'] !== '' ? floatval($_GET['ocena_od']) : '';
$ocena_do = isset($_GET['ocena_do']) && $_GET['ocena_do'] !== '' ? floatval($_GET['ocena_do']) : '';
if ($ocena_od !== '') {
    $szukanie[] = "q.ocena_uz >= $ocena_od";
}
if ($ocena_do !== '') {
    $szukanie[] = "q.ocena_uz <= $ocena_do";
}

$kategoria_id = isset($_GET['kategoria_id']) && $_GET['kategoria_id'] !== '' ? intval($_GET['kategoria_id']) : '';
if ($kategoria_id !== '') {
    $szukanie[] = "q.kategoria_id = $kategoria_id";
}

$premium = isset($_GET['premium']) ? $_GET['premium'] : '';
if ($premium === '1' || $premium === '0') {
    $p = $premium === '1' ? 1 : 0;
    $szukanie[] = "q.premium = $p";
}

$where = '';
if (count($szukanie) > 0) {
    $where = 'WHERE ' . implode(' AND ', $szukanie);
}
$sql = "SELECT q.*, k.nazwa AS kategoria, u.nazwa AS autor FROM quizy q JOIN kategoria k ON q.kategoria_id = k.id JOIN uzytkownicy u ON q.id_autor = u.id $where ORDER BY q.data_dodania DESC LIMIT 100";

$result = $conn->query($sql);
?>
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
    Witaj, <?= htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8') ?>
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
<form method="get" style="margin-bottom:10px; display:grid; grid-template-columns: repeat(4, 1fr); gap:8px; align-items:end;">
    <div><label>Data od/do:<br><input type="date" name="data_od" value="<?= htmlspecialchars($data_od) ?>">
    <input type="date" name="data_do" value="<?= htmlspecialchars($data_do) ?>"></label></div>
    <div><label>Ilość pytań od/do:<br><input type="number" min="0" name="pytania_od" value="<?= htmlspecialchars($pytania_od) ?>">
    <input type="number" min="0" name="pytania_do" value="<?= htmlspecialchars($pytania_do) ?>"></label></div>
    <div><label>Ocena od/do:<br><input type="number" step="0.1" min="0" max="10" name="ocena_od" value="<?= htmlspecialchars($ocena_od) ?>">
    <input type="number" step="0.1" min="0" max="10" name="ocena_do" value="<?= htmlspecialchars($ocena_do) ?>"></label></div>
    <div>
        <label>Kategoria:<br>
            <select name="kategoria_id">
                <option value="">Wszystkie</option>
                <?php foreach($kategorie as $kat): ?>
                    <option value="<?= $kat['id'] ?>" <?=($kategoria_id == $kat['id'] ? 'selected' : '')?>><?= htmlspecialchars($kat['nazwa']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </div>
    <div>
        <label>Premium:<br>
            <label><input type="radio" name="premium" value="" <?=($premium==''? 'checked':'')?>> Wszystkie</label>
            <label><input type="radio" name="premium" value="1" <?=($premium==='1'? 'checked':'')?>> Tak</label>
            <label><input type="radio" name="premium" value="0" <?=($premium==='0'? 'checked':'')?>> Nie</label>
        </label>
    </div>

    <div style="grid-column: span 4;">
        <button type="submit">Filtruj</button>
        <a href="index.php"><button type="button">Reset</button></a>
    </div>
    
</form>

<table border="1" cellpadding="5">
<tr>
    <th>Nazwa</th><th>Autor</th><th>Data dodania</th><th>Ilość pytań</th><th>Ocena</th><th>Kategoria</th><th>Premium</th>
</tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <tr onclick="window.location='graj.php?id=<?= urlencode($row['id']) ?>'" style="cursor:pointer;">
    <td><?= htmlspecialchars($row['nazwa'], ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= htmlspecialchars($row['autor'], ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= htmlspecialchars($row['data_dodania'], ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= htmlspecialchars($row['ilosc_pytan'], ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= htmlspecialchars($row['ocena_uz'], ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= htmlspecialchars($row['kategoria'], ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= $row['premium'] ? 'tak' : 'nie' ?></td>
</tr>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>


