<?php
session_start();
if(!isset($_SESSION['id'])) {
     header("Location: logowanie.php"); 
     exit(); 
    }

$conn = new mysqli("localhost","root","","quizy");
if($conn->connect_error) die("Błąd połączenia: " . $conn->connect_error);

$error = '';

if(isset($_POST['submit'])){
    $nazwa = trim($_POST['nazwa']);
    $kategoria = intval($_POST['kategoria']);
    $premium = isset($_POST['premium']) ? 1 : 0;
    $id_autor = $_SESSION['id'];
    $ilosc_pytan = intval($_POST['ilopyt']);

    if($nazwa !== '' && $ilosc_pytan > 0){
        $conn->query("INSERT INTO quizy (id_autor, data_dodania, nazwa, ilosc_pytan, kategoria_id, ocena_uz, ilosc_ocen, premium) 
                      VALUES ('$id_autor', NOW(), '$nazwa', '$ilosc_pytan', '$kategoria', 0, 0, '$premium')");
        if($conn->error) die("Błąd przy tworzeniu quizu: ".$conn->error);
        $quiz_id = $conn->insert_id;

        header("Location: dodaj_pytanie.php?id=$quiz_id");
        exit();
    } else {
        $error = "Wprowadź poprawną nazwę i ilość pytań.";
    }
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

<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post">
    <label>Nazwa quizu:</label><br>
    <input type="text" name="nazwa" required><br><br>

    <label>Ilość pytań:</label><br>
    <input type="number" name="ilopyt" min="1" required><br><br>

    <label>Kategoria:</label><br>
    <select name="kategoria" required>
        <?php while($row = $kat->fetch_assoc()): ?>
            <option value="<?=$row['id']?>"><?=($row['nazwa'])?></option>
        <?php endwhile; ?>
    </select><br><br>

    <?php if(isset($_SESSION['premium']) && $_SESSION['premium'] == 1): ?>
        <label>Premium:</label>
        <input type="checkbox" name="premium" value="1"><br><br>
    <?php endif; ?>

    <input type="submit" name="submit" value="Utwórz quiz">
</form>

<a href="index.php"><button>Powrót</button></a>
</body>
</html>
