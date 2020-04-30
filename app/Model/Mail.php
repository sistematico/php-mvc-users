<?php

namespace App\Model;

class Mail
{
    public function send($to, $name, $from, $subject, $message)
    {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: " . $from . "\r\n" . "Reply-To: " . $from . "\r\n" . "X-Mailer: PHP/" . phpversion();
        
        $body = "Name: " . $name . "<br />";
        $body .= 'E-mail: ' . $from . "<br />";
        $body .= "<br />";
        $body .= "Body: " . $message;
        
        if (@mail($to, $subject, $body, $headers)) {
            return "Sucesseful mail sent to {$to}";
        } else {
            return "Error sending mail to {$to}";
        }
    }
}