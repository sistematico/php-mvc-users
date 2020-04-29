<?php

namespace App\Model;

use App\Core\Model;

class User extends Model
{
    private $result = [];

    public function login($email, $password, $remember)
    {
        $sql = "SELECT id, user, email, password, role FROM user WHERE email LIKE :email OR user LIKE :email LIMIT 1";
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
                $_SESSION['role'] = $result->role;
                return "User {$result->user} logged in.";
            } else {
                return "User / E-mail {$email} not found.";
            }            
        }
    }

    public function signup($login, $email, $password, $role = 'user')
    {
        $sql = "INSERT INTO user (user, email, password, role) VALUES (:user, :email, :password, :role)";
        $query = $this->db->prepare($sql);
        $query->execute([':user' => $login, ':email' => $email, ':password' => password_hash($password, PASSWORD_DEFAULT), ':role' => $role]);
    }

    public function list()
    {
        $sql = "SELECT id, user, email, role FROM user";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM user WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id]);
    }

    public function get($id)
    {
        $sql = "SELECT id, user, email, password, role FROM user WHERE id = :id LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id]);
        return $query->fetch();
    }

    public function getUserId($email)
    {
        try {
            $sql = "SELECT id, user, email, role FROM user WHERE email = :email OR user = :email LIMIT 1";
            $query = $this->db->prepare($sql);
            $query->execute([':email' => $email]);
            return $query->fetch();
        } catch (\PDOException $e) {
            unset($e);
            return false;
        }
    }

    public function update($login, $email, $role, $id, $password)
    {
        $sql = "UPDATE user SET user = :user, email = :email, role = :role WHERE id = :id";
        $params = array(':user' => $login, ':email' => $email, ':role' => $role, ':id' => $id);
        
        if ($password !== null && strlen($password) > 0) {
            $sql = "UPDATE user SET user = :user, email = :email, password = :password, role = :role WHERE id = :id";
            $params = array(':user' => $login, ':email' => $email, ':password' => password_hash($password, PASSWORD_DEFAULT), ':role' => $role, ':id' => $id);
        }

        $query = $this->db->prepare($sql);
        $query->execute($params);
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
        $sql = "SELECT id, user, email, role FROM user WHERE email LIKE :term OR user LIKE :term";
        $query = $this->db->prepare($sql);
        $query->execute([':term' => $term]);
        while ($row = $query->fetch()) {
            $this->result[] = ['id' => $row->id, 'user' => $row->user, 'email' => $row->email, 'role' => $row->role];
        }
        return $this->result;
    }

    public function prune($table = 'user',$file = ROOT . 'users.sql')
    {
        try {
            $this->db->exec("DROP TABLE IF EXISTS $table");
        } catch (\PDOException $e) {
            return "Error droping table {$table}: " . $e->getMessage();
        }        

        try {
            $this->db->exec("CREATE TABLE IF NOT EXISTS $table (id INTEGER PRIMARY KEY, user TEXT, email TEXT, password TEXT, role TEXT)");
        } catch (\PDOException $e) {
            return "Error creating table {$table}: " . $e->getMessage();
        }

        if (file_exists($file)) {
            $sql = file_get_contents($file);
        
            try {
                $this->db->exec($sql);
                return "Database pruned";
            } catch(\PDOException $e) {
                return "Error importing data from {$file}: " . $e->getMessage();
            }
        } else {
            return "Database pruned, but file $file not found.";
        }

        return "Error deleting database";
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