<?php

/*
$ver = sha1(time());

$email = "mail@sebastian-engel.de";

$e = sha1($email);
$to = trim($email); 

$subject = "[Marktplatz.cc] Request to Reset Your Password";
 
        $headers = "From: Marktplatz.cc <donotreply@marktplatz.cc> Content-Type: text/plain";
 
        $msg = <<<EMAIL
We just heard you forgot your password! Bummer! To get going again,
head over to the link below and choose a new password.

Follow this link to reset your password:
http://www.vollrot.de/marktplatz/resetpassword.php?v=$ver&e=$e

If you have any questions, please contact info@coloredlists.com.

--
Thanks!

EMAIL;
 
mail($to, $subject, "blabla", $headers); 

echo $headers." => ".$to;
*/





// Die Nachricht
$nachricht = "blablabla";

// Send
mail('mail@sebastian-engel.de', 'Mein Betreff', $nachricht);
imap_mail('mail@sebastian-engel.de', 'Mein Betreff', $nachricht);


?>