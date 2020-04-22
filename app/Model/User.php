<?php

namespace App\Model;

use App\Core\Model;

class User extends Model
{
    public function getAllUsers()
    {
        $sql = "SELECT id, email, password FROM user";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function addUser($email, $password)
    {
        $sql = "INSERT INTO user (email, password) VALUES (:email, :password)";
        $query = $this->db->prepare($sql);
        $parameters = array(':email' => $email, ':password' => $password);
        $query->execute($parameters);
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

    public function updateUser($email, $password, $id)
    {
        $sql = "UPDATE user SET email = :email, password = :password WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':email' => $email, ':password' => $password, ':id' => $id);
        $query->execute($parameters);
    }

    public function getAmountOfUsers()
    {
        $sql = "SELECT COUNT(id) AS amount_of_users FROM user";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch()->amount_of_users;
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