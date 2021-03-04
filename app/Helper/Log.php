<?php

namespace App\Helper;

class Log
{
    public static function console($data)
    {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }

    public static function consoleRaw($data)
    {
        echo '<script>';
        echo 'console.log(' . $data . ')';
        echo '</script>';
    }
}