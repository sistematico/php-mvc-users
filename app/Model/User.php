<?php

namespace App\Model;

use App\Core\Model;

class User extends Model
{
    private $result = [];

    public function login($email, $password, $remember)
    {
        $sql = "SELECT id, user, email, password FROM user WHERE email LIKE :email OR user LIKE :email LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute([':email' => $email]);
        $result = $query->fetch();

        if ($result === false) {
            return "User not found.";
        } else {
            if (isset($result->id) && isset($result->password) && password_verify($password, $result->password)) {
                if ($remember !== false) {
                    setcookie("id", $result->id, time() + (86400 * 30), "/");
                    setcookie("user", $result->user, time() + (86400 * 30), "/");
                } 

                $_SESSION['logged'] = true;
                $_SESSION['id'] = $result->id;
                $_SESSION['user'] = $result->user;
                return "User {$result->user} logged in.";
            } else {
                return "User / E-mail {$email} not found.";
            }            
        }
    }

    public function signup($login, $email, $password)
    {
        $sql = "INSERT INTO user (user, email, password) VALUES (:user, :email, :password)";
        $query = $this->db->prepare($sql);
        $parameters = array(':user' => $login, ':email' => $email, ':password' => password_hash($password, PASSWORD_DEFAULT));
        $query->execute($parameters);
    }

    // public function logout()
    // {
    //     $sql = "SELECT id, email, password FROM user";
    //     $query = $this->db->prepare($sql);
    //     $query->execute();
    //     return $query->fetchAll();
    // }

    public function list()
    {
        $sql = "SELECT id, user, email, password FROM user";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM user WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);
    }

    public function getUser($id)
    {
        $sql = "SELECT id, user, email, password FROM user WHERE id = :id LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id]);
        return $query->fetch();
    }

    public function getUserId($email)
    {
        try {
            $sql = "SELECT id, email, password FROM user WHERE email = :email LIMIT 1";
            $query = $this->db->prepare($sql);
            $parameters = array(':email' => $email);
            $query->execute($parameters);
            return $query->fetch();
        } catch (\PDOException $e) {
            unset($e);
            return false;
        }
    }

    public function update($login, $email, $password, $id)
    {
        $sql = "UPDATE user SET login = :login, email = :email, password = :password WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute([':login' => $login, ':email' => $email, ':password' => password_hash($password, PASSWORD_DEFAULT), ':id' => $id]);
    }

    public function amount()
    {
        $sql = "SELECT COUNT(id) AS amount FROM user";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch()->amount;
    }

    public function search($term)
    {
        $term = "%" . $term . "%";
        $sql = "SELECT id, user, email, password FROM user WHERE email LIKE :term OR user LIKE :term";
        $query = $this->db->prepare($sql);
        $query->execute([':term' => $term]);
        while ($row = $query->fetch()) {
            $this->result[] = ['id' => $row->id, 'user' => $row->user, 'email' => $row->email, 'password' => $row->password];
        }
        return $this->result;
    }

    public function install()
    {
        $sql = "CREATE TABLE IF NOT EXISTS user (id INTEGER PRIMARY KEY, user TEXT, email TEXT, password TEXT)";
        try {
            $this->db->exec($sql);
        } catch(\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function prune($table = 'user')
    {
        $this->db->exec("DROP TABLE IF EXISTS $table");

        try {
            $this->db->exec("CREATE TABLE IF NOT EXISTS $table (id INTEGER PRIMARY KEY, user TEXT, email TEXT, password TEXT)");
            return "Table $table recreated";
        } catch (\PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function populate($file = ROOT . 'users.sql')
    {
        if (file_exists($file)) {
            $sql = file_get_contents($file);
        } else {
            return "File $file not found.";
        }

        try {
            $this->db->exec($sql);
            return "Data imported";
        } catch(\PDOException $e) {
            return "Error: " . $e->getMessage();
        }

        return "Error importing data";
    }

    public function getTableList()
    {
        $sql = "SELECT name FROM sqlite_master WHERE type='table'";
        $query = $this->db->query($sql);
        return $query->fetch();
    }

    public function tableExists($table = 'user')
    {
        $sql = "select 1 from $table";
        try {
            $this->db->exec($sql);
            return true;
        } catch(\PDOException $e) {
            unset($e);
            return false;
        }

        return false;
    }    
}