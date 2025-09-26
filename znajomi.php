<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Znajomi</title>
</head>
<body>
    <h1>Twoi znajomi:</h1>
    <form method="post" style="margin-bottom:20px;">
        <label for="add_friend">Dodaj znajomego po nazwie:</label>
        <input type="text" name="add_friend" id="add_friend" minlength="3" maxlength="60" required>
        <button type="submit" name="submit_add">Wyślij zaproszenie</button>
    </form>
    <?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "quizy");
    $user_id = $_SESSION['id'];
    if (isset($_POST['submit_add']) && isset($_POST['add_friend'])) {
        $nazwa_znaj = $conn->real_escape_string($_POST['add_friend']);
        $count = $conn->query("SELECT COUNT(*) as ile FROM `znajomi` WHERE (`id_nadawcy` = '$user_id' OR `id_odbiorcy` = '$user_id') AND `przyjeto` = '1'")->fetch_assoc()['ile'];
        if ($count >= 10) {
            echo '<div style="color:red;">Osiągnięto limit 10 znajomych!</div>';
        } else {
            $friend = $conn->query("SELECT id FROM `uzytkownicy` WHERE `nazwa` = '$nazwa_znaj'")->fetch_assoc();
            if (!$friend) {
                echo '<div style="color:red;">Użytkownik o podanej nazwie nie istnieje!</div>';
            } else {
                $friend_id = $friend['id'];
                $already = $conn->query("SELECT * FROM `znajomi` WHERE ((`id_nadawcy` = '$user_id' AND `id_odbiorcy` = '$friend_id') OR (`id_nadawcy` = '$friend_id' AND `id_odbiorcy` = '$user_id'))")->num_rows;
                if ($already > 0) {
                    echo '<div style="color:red;">Już wysłano zaproszenie lub jesteście znajomymi!</div>';
                } else if ($friend_id == $user_id) {
                    echo '<div style="color:red;">Nie możesz dodać siebie!</div>';
                } else {
                    $conn->query("INSERT INTO `znajomi` (`id_nadawcy`, `id_odbiorcy`, `przyjeto`) VALUES ('$user_id', '$friend_id', '0')");
                    echo '<div style="color:green;">Zaproszenie wysłane!</div>';
                }
            }
        }
    }
    ?>
    <table>
        <tr>
            <th>nazwa</th>
            <th>zarządzaj</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM `znajomi` JOIN `uzytkownicy`  ON znajomi.id_nadawcy = uzytkownicy.id WHERE (`id_nadawcy` = '$user_id' OR `id_odbiorcy` = '$user_id') AND `przyjeto` = '1'");
        while ($row = $result->fetch_assoc()) {
            if ($row['id_nadawcy'] == $user_id) {
                $drugi = $row['id_odbiorcy'];
            } 
            else {
                $drugi = $row['id_nadawcy'];
            }
            echo '<tr>';
            echo '<td>' . $row['nazwa'] . '</td>';
            echo '<td><a href="usun_znajomego.php?id=' . $drugi . '" onclick="return confirm(\'Czy na pewno chcesz usunąć tego znajomego?\');"><button>Usuń</button></a></td>';
            echo '</tr>';
        }
        ?>
    </table>

    <h2>Zaproszenia oczekujące:</h2>
    <table>
        <tr>
            <th>Nadawca</th>
            <th>Akcja</th>
        </tr>
        <?php
        $oczekujace = $conn->query("SELECT * FROM `znajomi`  JOIN `uzytkownicy`  ON znajomi.id_nadawcy = uzytkownicy.id WHERE znajomi.id_odbiorcy = '$user_id' AND znajomi.przyjeto = '0'");
        while ($row = $oczekujace->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['nazwa'] . '</td>';
            echo '<td>';
            echo '<a href="akceptuj.php?id=' . $row['id'] . '"><button>Akceptuj</button></a> ';
            echo '<a href="odrzuc.php?id=' . $row['id'] . '"><button>Odrzuć</button></a>';
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </table>
</body>
</html>