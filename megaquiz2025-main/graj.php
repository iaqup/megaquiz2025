<?php
session_start();
$_SESSION['czas'] = microtime(true);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="graj.css">
    <title>Gra w quiz</title>
    <script src="quiz.js" defer></script>
</head>
<body>
    <h1 id="quiz-title">Ładowanie quizu...</h1>
    <div id="quiz-container"></div>
    <button id="submit-btn" style="display:none;">Zakończ quiz</button>

</body>
</html>
