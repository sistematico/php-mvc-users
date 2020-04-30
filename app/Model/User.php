<?php

namespace App\Model;

use App\Core\Model;

class User extends Model
{
    private $result = [];

    public function login($email, $password, $remember)
    {
        $sql = "SELECT id, user, email, role, password, valid FROM user WHERE email LIKE :email OR user LIKE :email LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute([':email' => $email]);
        $result = $query->fetch();

        if ($result === false) {
            return "User not found.";
        }

        if (isset($result->valid) && $result->valid == 0) {
            return "Validate first";
        }

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

    public function signup($login, $email, $password)
    {
        try {
            $hash = md5(uniqid(rand(), TRUE));
            $query = $this->db->prepare("INSERT INTO user (user, email, role, password, temp, valid) VALUES (:user, :email, :role, :password, :temp, :valid)");
            $query->execute([':user' => $login, ':email' => $email, ':role' => 'user', ':password' => password_hash($password, PASSWORD_DEFAULT), ':temp' => $hash, ':valid' => 0]);
            $Mail = new Mail();
            return $Mail->send($email, $login, 'system@lucasbrum.net', 'New registration', 'Welcome to our site!<br /><br />This is your hash: ' . $hash);
        } catch (\PDOException $e) {
            unset($e);
            return "Error adding user {$login}";
        }

        return "Success adding user ${login}, verification e-mail sent to {$email}";
    }

    public function verify($hash)
    {
        $sql = "SELECT id, user, email, password, role FROM user WHERE temp = :hash LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute([':hash' => $hash]);
        $user = $query->fetch();

        if ($user === false) {
            return "Invalid code";
        } else if ($user->id && $user->email && $user->valid) {
            $this->update($user->user, $user->email, $user->role, 1, $user->id);
            return "{$user->email} sucessful validated";
        } else {
            return "Error";
        }
    }

    public function list()
    {
        $sql = "SELECT id, user, email, role, valid FROM user";
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
            $sql = "SELECT id, user, email, role, valid FROM user WHERE email = :email OR user = :email LIMIT 1";
            $query = $this->db->prepare($sql);
            $query->execute([':email' => $email]);
            return $query->fetch();
        } catch (\PDOException $e) {
            unset($e);
            return false;
        }
    }

    public function update($login, $email, $role, $valid, $id, $password = null)
    {
        $sql = "UPDATE user SET user = :user, email = :email, role = :role, valid = :valid WHERE id = :id";
        $params = array(':user' => $login, ':email' => $email, ':role' => $role, ':valid' => $valid, ':id' => $id);
        
        if ($password !== null && strlen($password) > 0) {
            $temp = md5(uniqid(rand(), TRUE));
            $sql = "UPDATE user SET user = :user, email = :email, role = :role, password = :password, valid = :valid  WHERE id = :id";
            $params = array(':user' => $login, ':email' => $email, ':role' => $role, ':password' => password_hash($password, PASSWORD_DEFAULT), ':temp' => $temp, ':valid' => $valid, ':id' => $id);
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
        $sql = "SELECT id, user, email, role, valid FROM user WHERE email LIKE :term OR user LIKE :term";
        $query = $this->db->prepare($sql);
        $query->execute([':term' => $term]);
        while ($row = $query->fetch()) {
            $this->result[] = ['id' => $row->id, 'user' => $row->user, 'email' => $row->email, 'role' => $row->role, 'valid' => $row->valid];
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
            $this->db->exec("CREATE TABLE IF NOT EXISTS $table (id INTEGER PRIMARY KEY, user TEXT, email TEXT, role TEXT, password TEXT, temp TEXT, valid INTEGER)");
        } catch (\PDOException $e) {
            return "Error creating table {$table}: " . $e->getMessage();
        }

        if (file_exists($file)) {
            $sql = file_get_contents($file);
            $sql = explode("\n", $sql);            

            foreach ($sql as $value) {
                try {
                    $value = str_replace("{{TEMPID}}", md5(uniqid(rand(), TRUE)), $value);
                    $this->db->exec($value);
                } catch (\PDOException $e) {
                    return "Exception: " . $e->getMessage();
                }
            }  
        } else {
            return "Database pruned, but file $file not found.";
        }

        return "Database created";
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