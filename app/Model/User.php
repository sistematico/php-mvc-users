<?php

namespace App\Model;

use App\Core\Model;
use PDOException;

class User extends Model
{
    private array $results = [];

    public function login($email, $password, $remember): string
    {
        $sql = "SELECT id, user, email, role, password, valid FROM user WHERE email LIKE :email OR user LIKE :email LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute([':email' => $email]);

        if (!$result = $query->fetch()) {
            return json_encode(['status' => 'error', 'message' => 'User not found.']);
        }

        if (isset($result->valid) && $result->valid == 0) {
            return json_encode(['status' => 'error', 'message' => 'Validate first']);
        }

        if (isset($result->id) && isset($result->password) && password_verify($password, $result->password)) {
            $this->access($result->id);

            if ($remember !== false) {
                setcookie("id", $result->id, time() + (86400 * 30), "/");
                setcookie("user", $result->user, time() + (86400 * 30), "/");
            } 

            $_SESSION['logged'] = true;
            $_SESSION['id'] = $result->id;
            $_SESSION['user'] = $result->user;
            $_SESSION['role'] = $result->role;
            return json_encode(['status' => 'success', 'message' => 'User {$result->user} logged in.'], JSON_FORCE_OBJECT);
        } else {
            return json_encode(['status' => 'error', 'message' => 'User / E-mail {$email} not found.'], JSON_FORCE_OBJECT);
        }
    }

    public function signup($login, $email, $password): bool|string
    {
        if ($this->check($login,$email)['status'] !== 'success') {
            return $this->check($login,$email);
        }

        $ts = time();
        $hash = md5(uniqid(rand(), TRUE));
        
        if (defined('DEBUG') && DEBUG === true) {
            $Mail = new Mail();
            $send = $Mail->sendHash($email, $login, $hash);        

            if ($send === false) {
                return "Error sending e-mail to {$email}";
            }
        }
        
        try {
            $query = $this->db->prepare("INSERT INTO user (user, email, role, password, temp, valid, access, created) VALUES (:user, :email, :role, :password, :temp, :valid, :access, :created)");
            $query->execute([':user' => $login, ':email' => $email, ':role' => 'user', ':password' => password_hash($password, PASSWORD_DEFAULT), ':temp' => $hash, ':valid' => 0, ':access' => $ts, ':created' => $ts]);
        } catch (PDOException $e) {
            unset($e);
            if (defined('DEBUG') && DEBUG === true) {
                $Mail->send($email, $login, 'Error inserting hash', 'Error sending hash! Re-send please.');
            }
            return json_encode(['status' => 'error', 'message' => "Error adding user {$login}"], JSON_FORCE_OBJECT);
        }

        if (defined('DEBUG') && DEBUG === true) {
            return json_encode(['status' => 'success', 'message' => "Success adding user ${login}, verification e-mail NOT sent to {$email}, Hash: {$hash}"], JSON_FORCE_OBJECT);
        } else {
            return json_encode([
                'status' => 'success',
                'message' => "Success adding user ${login}, verification e-mail sent to {$email}"
            ], JSON_FORCE_OBJECT);
        }
    }

    public function reset($email): string
    {
        $user = $this->getUserId($email);
        
        if ($user) {
            if (defined('DEBUG') && DEBUG === true) {
                $Mail = new Mail();
                $send = $Mail->sendHash($user->email, $user->user, $user->hash);        

                if ($send === false) {
                    return json_encode(['status' => 'error', 'message' => "Error sending e-mail to {$user->email}"], JSON_FORCE_OBJECT);
                }
            }
        
            if (DEBUG === true) {
                return json_encode([
                    'status' => 'success',
                    'message' => "Success resetting user {$user->user} password verification e-mail NOT sent to {$user->email}, New Hash: {$user->hash}"
                ], JSON_FORCE_OBJECT);
            } else {
                return json_encode([
                    'status' => 'success',
                    'message' => 'Success resetting user $user->user , verification e-mail sent to {$user->email}.'
                ], JSON_FORCE_OBJECT);
            }
        } else {
            return json_encode(['status' => 'error', 'message' => 'Error resetting password.'], JSON_FORCE_OBJECT);
        }
    }

    public function verify($hash): string
    {
        $sql = "SELECT id, user, email, password, role, temp, valid FROM user WHERE temp = :hash LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute([':hash' => $hash]);
        $user = $query->fetch();

        if ($user == false) {
            return json_encode(["status" => "error", "message" => "Invalid code"]);
        } else if ($user->valid == 1) {
            return json_encode(['status' => 'error', 'message' => "{$user->email} already validated"], JSON_FORCE_OBJECT);
        } else if ($user->id && $hash === $user->temp) {
            $this->validate($user->id);
            return json_encode(['status' => 'success', 'message' => "{$user->email} successful validated"], JSON_FORCE_OBJECT);
        }
        return json_encode(['status' => 'error', 'message' => 'Undefined error.'], JSON_FORCE_OBJECT);
    }

    public function list(): object
    {
        $query = $this->db->prepare("SELECT id, user, email, role, password, temp, valid, access, created FROM user");
        $query->execute();
        while ($row = $query->fetch()) {
            $this->results[] = $row;
        }
        return (object) $this->results;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM user WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id]);
    }

    public function get($id)
    {
        $sql = "SELECT id, user, email, password, role, temp, valid FROM user WHERE id = :id LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute([':id' => $id]);
        return $query->fetch();
    }

    public function getUserId($email): bool
    {
        try {
            $sql = "SELECT id, user, email, role, temp, valid FROM user WHERE email = :email OR user = :email LIMIT 1";
            $query = $this->db->prepare($sql);
            $query->execute([':email' => $email]);
            return $query->fetch();
        } catch (PDOException $e) {
            unset($e);
            return false;
        }
    }

    public function check($login, $email): bool|string
    {
        $query = $this->db->prepare("SELECT id FROM user WHERE email = :email LIMIT 1");
        $query->execute([':email' => $email]);

        if ($query->fetch() !== false) {
            return json_encode(['status' => 'error', 'message' => 'E-mail {$email} already exists']);
        }

        $query = $this->db->prepare("SELECT id FROM user WHERE user = :user LIMIT 1");
        $query->execute([':user' => $login]);
        if ($query->fetch() != false) {
            return json_encode(['status' => 'error', 'message' => 'Username {$login} already exists']);
        }

        return json_encode(['status' => 'success']);
    }

    public function update($login, $email, $role, $id, $valid, $password)
    {
        $_SESSION['user'] = $login;
        
        $sql = "UPDATE user SET user = :user, email = :email, role = :role, valid = :valid WHERE id = :id";
        $params = array(':user' => $login, ':email' => $email, ':role' => $role, ':valid' => $valid, ':id' => $id);
        
        if ($password != null && strlen($password) > 0) {
            $temp = md5(uniqid(rand(), TRUE));
            $sql = "UPDATE user SET user = :user, email = :email, role = :role, password = :password, temp = :temp, valid = :valid WHERE id = :id";
            $params = [':user' => $login, ':email' => $email, ':role' => $role, ':password' => password_hash($password, PASSWORD_DEFAULT), ':temp' => $temp, ':valid' => $valid, ':id' => $id];
        }

        $query = $this->db->prepare($sql);
        $query->execute($params);
    }

    public function access($id)
    {
        $query = $this->db->prepare("UPDATE user SET access = :access WHERE id = :id");
        $query->execute([':id' => $id, ':access' => time()]);
    }

    public function validate($id)
    {
        $sql = "UPDATE user SET temp = :hash, valid = :valid WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute([':hash' => md5(uniqid(rand(), TRUE)), ':valid' => 1, ':id' => $id]);
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
        $sql = "SELECT id, user, email, role, temp, valid, access, created FROM user WHERE email LIKE :term OR user LIKE :term";
        $query = $this->db->prepare($sql);
        $query->execute([':term' => $term]);
        while ($row = $query->fetch()) {
            $this->results[] = $row;
        }
        return (object) $this->results;
    }

    public function prune()
    {
        try {
            $this->db->exec('DROP TABLE IF EXISTS user');
        } catch (PDOException $e) {
            return json_encode(["status" => "error", "message" => "Error droping table: " . $e->getMessage()]);
        }

        if (file_exists(SQL_FILE)) {
            $sql = file_get_contents(SQL_FILE);
            try {
                $this->db->exec($sql);
            } catch (PDOException $e) {
                return json_encode(["status" => "error", "message" => "Exception: " . $e->getMessage()]);
            }
        } else {
            return json_encode(["status" => "error", "message" => "Database pruned, but file " . SQL_FILE . " not found."]);
        }

        return json_encode(["status" => "success", "message" => "Database created"]);
    }

    public function tableExists($table = 'user'): bool
    {
        $sql = "select 1 from $table";
        try {
            $this->db->exec($sql);
            return true;
        } catch(PDOException $e) {
            unset($e);
            return false;
        }
    }
}