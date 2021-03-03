<?php

namespace App\Model;

use JetBrains\PhpStorm\Pure;

class Mail
{

    private static string $name = 'PHP MVC Users';
    private static string $from = 'no-reply@lucasbrum.net';

    /**
     * @param $to
     * @param $name
     * @param $subject
     * @param $message
     * @return bool
     */
    public static function send($to, $name, $subject, $message): bool
    {
        $body = "Name: " . self::$name . "<br />";
        $body .= 'E-mail: ' . self::$from . "<br />";
        $body .= "<br />" . $message;
        $headers = self::makeHeader($to, $name);
        
        if (@mail($to, $subject, $body, $headers)) {
            return true;
        }

        return false;
    }

    /**
     * @param $to
     * @param $name
     * @param $hash
     * @return bool
     */
    public static function sendHash($to, $name, $hash): bool
    {
        $body = 'Welcome to our site!<br /><br />This is your hash: <a href="' . URL . 'users/verify/' . $hash . '">' . $hash . '</a>';
        $subject = 'New registration';
        $headers = self::makeHeader($to, $name);
        
        if (@mail($to, $subject, $body, $headers)) {
            return true;
        }

        return false;
    }

    /**
     * @param $to
     * @param $name
     * @return string
     */
    #[Pure] private static function makeHeader($to, $name): string
    {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: Site <" . self::$from . ">\r\n";
        $headers .= "Reply-To: " . $name . " <" . $to . ">\r\n";
        $headers .= "Return-Path: Site <" . self::$from . ">\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        return $headers;
    }
}