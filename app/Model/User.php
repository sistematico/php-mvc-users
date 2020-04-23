<?php

namespace App\Model;

use App\Core\Model;

class User extends Model
{
    private $result = [];

    public function login($email,$password)
    {
        $sql = "SELECT id, email, password FROM user WHERE email LIKE :email LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute([':email' => $email]);
        $result = $query->fetch();

        if ($result === false) {
            return "User not found.";
        } else {
            if (isset($result->id) && isset($result->password) && password_verify($password, $result->password)) {
                $_SESSION['logged'] = true;
                $_SESSION['id'] = $result->id;
                return "User logged in.";
            } else {
                return "User not found.";
            }            
        }
    }

    public function signup($email, $password)
    {
        $sql = "INSERT INTO user (email, password) VALUES (:email, :password)";
        $query = $this->db->prepare($sql);
        $parameters = array(':email' => $email, ':password' => password_hash($password, PASSWORD_DEFAULT));
        $query->execute($parameters);
    }

    public function logout()
    {
        $sql = "SELECT id, email, password FROM user";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function list()
    {
        $sql = "SELECT id, email, password FROM user";
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
        $sql = "SELECT id, email, password FROM user WHERE id = :id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);
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

    public function update($email, $password, $id)
    {
        $sql = "UPDATE user SET email = :email, password = :password WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':email' => $email, ':password' => password_hash($password, PASSWORD_DEFAULT), ':id' => $id);
        $query->execute($parameters);
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
        $sql = "SELECT id, email, password FROM user WHERE email LIKE :term";
        $query = $this->db->prepare($sql);
        $query->execute([':term' => $term]);
        while ($row = $query->fetch()) {
            $this->result[] = ['id' => $row->id, 'email' => $row->email, 'password' => $row->password];
        }
        return $this->result;
    }

    public function install()
    {
        $sql = "CREATE TABLE IF NOT EXISTS user (id INTEGER PRIMARY KEY, email TEXT, password TEXT)";
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
            $this->db->exec("CREATE TABLE IF NOT EXISTS $table (id INTEGER PRIMARY KEY, email TEXT, password TEXT)");
            return "Tabela $table recriada com sucesso.<br />";
        } catch (\PDOException $e) {
            return "Erro ao criar tabela $table: " . $e->getMessage() . "<br />";
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
            //unset($e);
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