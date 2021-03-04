<?php

namespace App\Core;
use PDO;

class Model
{
    public $db = null;

    function __construct() {
        try {
            $this->open();
        } catch (\PDOException $e) {
            exit('Connection with database cannot be made.');
        }
    }

    private function open() {
        if (!is_dir(dirname(DB_FILE)))
            mkdir(dirname(DB_FILE), 0755);

        if (!is_file(DB_FILE))
            touch(DB_FILE);

        $this->db = new PDO('sqlite:' . DB_FILE);
        $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
    }
}
