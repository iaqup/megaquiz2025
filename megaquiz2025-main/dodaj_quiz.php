<?php
session_start();

if(!isset($_SESSION['id'])) {
    header("Location: logowanie.php");
    exit();
}

$conn = new mysqli("localhost","root","","quizy");
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

if(isset($_POST['submit'])){
    $nazwa = $conn->real_escape_string($_POST['nazwa']);
    $kategoria = intval($_POST['kategoria']);
    $premium = isset($_POST['premium']) ? 1 : 0;
    $id_autor = $_SESSION['id'];
    $conn->query("INSERT INTO quizy (`id_autor`,`data_dodania`,`nazwa`,`ilosc_pytan`,`kategoria_id`,`ocena_uz`,`ilosc_ocen`,`premium`) 
                  VALUES ('$id_autor',NOW(),'$nazwa',0,'$kategoria',0,0,'$premium')");
    $quiz_id = $conn->insert_id;

    header("Location: dodaj_pytanie.php?id=$quiz_id&pytanie=1");
    exit();
}

$kat = $conn->query("SELECT * FROM kategoria");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Dodaj nowy quiz</title>
</head>
<body>
<h1>Dodaj nowy quiz</h1>
<form method="post">
    <label>Nazwa quizu:</label><br>
    <input type="text" name="nazwa" required><br><br>
    <label>Kategoria:</label><br>
    <select name="kategoria" required>
        <?php while($row = $kat->fetch_assoc()): ?>
            <option value="<?=$row['id']?>"><?=($row['nazwa'])?></option>
        <?php endwhile; ?>
    </select><br><br>
    <?php
    if(isset($_SESSION['premium']) && $_SESSION['premium'] == '1'): ?>
    <label>Premium:</label>
    <input type="checkbox" name="premium" default="0"><br><br>
    <?php endif; ?>

    <input type="submit" name="submit" value="Utwórz quiz">
</form>
<a href="index.php"><button>Powrót</button></a>
</body>
</html>
