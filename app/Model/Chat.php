<?php

namespace App\Model;
use App\Core\Model;
use PDOException;

class Chat extends Model
{
    public array $results = [];

    public function send($message)
    {
        $query = $this->db->prepare("INSERT INTO " . CHAT_TABLE . " (user_id, message, timestamp) VALUES (:user_id, :message, :timestamp);");
        $query->execute([':user_id' => 1, ':message' => $message, ':timestamp' => time()]);
    }

    public function list(): array
    {
        $query = $this->db->prepare("SELECT id, user_id, message, timestamp FROM " . CHAT_TABLE . "");
        $query->execute();
        while ($row = $query->fetch()) {
            $this->results[] = $row;
        }
        return $this->results;
    }

    public function delete($id)
    {
        $query = $this->db->prepare("DELETE FROM " . CHAT_TABLE . " WHERE id = :id");
        $query->execute([':id' => $id]);
    }

    public function get($id)
    {
        try {
            $query = $this->db->prepare("SELECT id, user, email, password, role, temp, valid FROM " . USERS_TABLE . " WHERE id = :id LIMIT 1");
            $query->execute([':id' => $id]);
            return $query->fetch();
        } catch (PDOException $e) {
            unset($e);
            return false;
        }
    }

    public function amount()
    {
        $sql = "SELECT COUNT(id) AS amount FROM " . CHAT_TABLE . ";";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch()->amount;
    }
}