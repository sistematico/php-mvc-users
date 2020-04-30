<?php

namespace App\Model;

class Mail
{

    private $name = 'PHP MVC Users';
    private $from = 'contato@lucasbrum.net';

    public function send($to, $subject, $message)
    {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: " . $this->from . "\r\n" . "Reply-To: " . $this->from . "\r\n" . "X-Mailer: PHP/" . phpversion();
        
        $body = "Name: " . $this->name . "<br />";
        $body .= 'E-mail: ' . $this->from . "<br />";
        $body .= "<br />" . $message;
        
        if (@mail($to, $subject, $body, $headers)) {
            return "Sucesseful mail sent to {$to}";
        } else {
            return "Error sending mail to {$to}";
        }
    }

    public function sendHash($to,$hash)
    {
        $body = 'Welcome to our site!<br /><br />This is your hash: <a href="' . URL . 'users/verify/' . $hash . '">' . $hash . '</a>';
        $subject = 'New registration'; 

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: " . $this->from . "\r\n" . "Reply-To: " . $this->from . "\r\n" . "X-Mailer: PHP/" . phpversion();
        
        if (@mail($to, $subject, $body, $headers)) {
            return true;
        } else {
            return false;
        }
    }    
}