<?php
$to = "jacek12prokop@gmail.com";  // Twój prywatny mail
$subject = "Potwierdzenie logowania - Quiz";
$message = "Cześć!\n\nNa Twoje konto w quizie właśnie się zalogowano.\n\nPozdrawiamy,\nZespół Quiz";

$headers  = "From: Quiz <quiz@mkwk018.cba.pl>\r\n";  
$headers .= "Reply-To: quiz@mkwk018.cba.pl\r\n";  
$headers .= "X-Mailer: PHP/" . phpversion();

if (mail($to, $subject, $message, $headers)) {
    echo "✅ Mail wysłany (sprawdź także folder SPAM).";
    
} else {
    echo "❌ Błąd przy wysyłaniu.";
}
