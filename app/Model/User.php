<?php

namespace App\Model;

use App\Core\Model;

class User extends Model
{
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

    public function deleteUser($id)
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

    public function updateUser($email, $password, $id)
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

    public function searchUsers($term)
    {
        $term = "%" . $term . "%";
        $sql = "SELECT id, email, password FROM user WHERE email LIKE :term";
        $query = $this->db->prepare($sql);
        //$query->bindParam(':term', $term);
        $query->execute([':term' => $term]);
        //$query->execute();

        $tasks = [];

        while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
            $tasks[] = [
                'id' => $row['id'],
                'email' => $row['email'],
                'password' => $row['password']
            ];
        }
        return $tasks;
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