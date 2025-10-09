<?php
header('Content-Type: application/json; charset=utf-8');
$conn = new mysqli("localhost","megaquiz","Megahaslo2.","megaquiz");    
if ($conn->connect_errno) {
    echo json_encode(['error'=>'DB error']); exit; 
}

$quiz_id = intval($_GET['id'] ?? 0);
if ($quiz_id <= 0) { 
    echo json_encode(['error'=>'Brak id']); exit; 
}

$quiz = $conn->query("SELECT id, nazwa, ilosc_pytan, kategoria_id, premium FROM quizy WHERE id = $quiz_id")->fetch_assoc();
if (!$quiz) { 
    echo json_encode(['error'=>'Quiz nie znaleziony']); exit; 
}

$pytania = [];
$res = $conn->query("SELECT id, tresc, typ FROM pytania WHERE quiz_id = $quiz_id ORDER BY kolejnosc, id");
while ($p = $res->fetch_assoc()) {
    $p['odpowiedzi'] = [];
    if ($p['typ'] == 'abcd') {
        $odp_res = $conn->query("SELECT id, tresc FROM odpowiedzi WHERE pytanie_id = ".$p['id']." ORDER BY kolejnosc, id");
        while ($o = $odp_res->fetch_assoc()) $p['odpowiedzi'][] = $o;
    }
    $pytania[] = $p;
}

echo json_encode(['quiz'=>$quiz, 'pytania'=>$pytania], JSON_UNESCAPED_UNICODE);
