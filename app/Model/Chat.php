<?php

namespace App\Model;
use App\Core\Model;
use PDOException;

class Chat extends Model
{
    public array $results = [];

    public function send($message)
    {
        if (isset($_SESSION['user']) && isset($_SESSION['id'])) {
            $query = $this->db->prepare("INSERT INTO " . CHAT_TABLE . " (user_id, user, message, timestamp) VALUES (:user_id, :user, :message, :timestamp);");
            $query->execute([':user_id' => $_SESSION["id"], ':user' => $_SESSION["user"], ':message' => $message, ':timestamp' => time()]);
        }
    }

    public function list(): array
    {
        $this->cleanOlder();

        $query = $this->db->prepare("SELECT id, user_id, user, message, timestamp FROM " . CHAT_TABLE);
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

    public function cleanOlder()
    {
        if ($this->amount() > 500) {
            $query = $this->db->prepare("DELETE FROM " . CHAT_TABLE . " WHERE id IS NOT NULL ORDER BY timestamp LIMIT 1");
            $query->execute();
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