<?php

namespace App\Model;

use App\Core\Model;

use PDOException;

class User extends Model
{
    private array $results = [];

    public function login($email, $password, $remember): array
    {
        $sql = "SELECT id, user, email, role, password, valid FROM user WHERE email LIKE :email OR user LIKE :email LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute([':email' => $email]);

        if (!$result = $query->fetch()) {
            return ['status' => 'error', 'message' => 'User not found.'];
        }

        if (isset($result->valid) && $result->valid == 0) {
            return ['status' => 'error', 'message' => 'Validate first'];
        }

        if (isset($result->id) && isset($result->password) && password_verify($password, $result->password)) {
            $this->access($result->id);

            if ($remember !== false) {
                setcookie("id", $result->id, time() + (86400 * 30), "/");
                setcookie("user", $result->user, time() + (86400 * 30), "/");
            }

            unset($_SESSION['last_message'], $_SESSION['last_class']);

            $_SESSION['logged'] = true;
            $_SESSION['id'] = $result->id;
            $_SESSION['user'] = $result->user;
            $_SESSION['role'] = $result->role;

            return ['status' => 'success', 'message' => "User {$result->user} logged in."];
        } else {
            return ['status' => 'error', 'message' => "User / E-mail {$email} not found."];
        }
    }

    public function signup($login, $email, $password): array
    {
        $check = $this->check($login,$email);

        if ($check['status'] === 'success')
            return $check;

        $ts = time();
        $hash = md5(uniqid(rand(), TRUE));
        unset($_SESSION['last_message'], $_SESSION['last_class']);

        try {
            $query = $this->db->prepare("INSERT INTO user (user, email, role, password, temp, valid, access, created) VALUES (:user, :email, :role, :password, :temp, :valid, :access, :created)");
            $query->execute([':user' => $login, ':email' => $email, ':role' => 'user', ':password' => password_hash($password, PASSWORD_DEFAULT), ':temp' => $hash, ':valid' => 0, ':access' => $ts, ':created' => $ts]);
        } catch (PDOException $e) {
            unset($e);
            if (MODE !== 'development') {
                if (!Mail::send($email, $login, 'Error inserting hash', 'Error sending hash! Re-send please.')) {
                    return ['status' => 'error', 'message' => "Error sending e-mail."];
                }
            }
            return ['status' => 'error', 'message' => "Error adding user {$login}"];
        }

        if (MODE === 'development') {
            return ['status' => 'success', 'message' => "Success adding user ${login}, verification e-mail NOT sent to {$email}, Hash: {$hash}"];
        } else {
            if (!Mail::sendHash($email, $login, $hash)) {
                return ['status' => 'error', 'message' => "Error sending e-mail to {$email}"];
            }
            return [
                'status' => 'success',
                'message' => "Success adding user ${login}, verification e-mail sent to {$email}"
            ];
        }
    }

    public function reset($email): array
    {
        if ($user = $this->getUserId($email)) {
            if (MODE !== 'development') {
                if (!Mail::sendHash($user->email, $user->user, $user->hash)) {
                    return ['status' => 'error', 'message' => "Error sending e-mail to {$user->email}"];
                }
                return [
                    'status' => 'success',
                    'message' => "Success resetting user $user->user , verification e-mail sent to {$user->email}."
                ];
            } else  {
                return [
                    'status' => 'success',
                    'message' => "Success resetting user {$user->user} password verification e-mail NOT sent to {$user->email}, New Hash: {$user->hash}"
                ];
            }
        } else {
            return ['status' => 'error', 'message' => 'Error resetting password.'];
        }
    }

    public function verify($hash): array
    {
        $query = $this->db->prepare("SELECT id, user, email, password, role, temp, valid FROM user WHERE temp = :hash LIMIT 1");
        $query->execute([':hash' => $hash]);

        if (!$user = $query->fetch()) {
            return ["status" => "error", "message" => "Invalid code"];
        } else if ($user->valid == 1) {
            return ['status' => 'error', 'message' => "{$user->email} already validated"];
        } else if ($user->id && $hash === $user->temp) {
            $this->validate($user->id);
            return ['status' => 'success', 'message' => "{$user->email} successful validated"];
        }
        return ['status' => 'error', 'message' => 'Undefined error.'];
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
        try {
            $query = $this->db->prepare("SELECT id, user, email, password, role, temp, valid FROM user WHERE id = :id LIMIT 1");
            $query->execute([':id' => $id]);
            return $query->fetch();
        } catch (PDOException $e) {
            unset($e);
            return false;
        }
    }

    public function getUserId($email): bool
    {
        try {
            $query = $this->db->prepare("SELECT id, user, email, role, temp, valid FROM user WHERE email = :email OR user = :email LIMIT 1");
            $query->execute([':email' => $email]);
            return $query->fetch();
        } catch (PDOException $e) {
            unset($e);
            return false;
        }
    }

    public function check($login, $email): array
    {
        $query = $this->db->prepare("SELECT id FROM user WHERE email = :email LIMIT 1");
        $query->execute([':email' => $email]);

        if ($query->fetch() !== false) {
            return ['status' => 'error', 'message' => 'E-mail {$email} already exists'];
        }

        $query = $this->db->prepare("SELECT id FROM user WHERE user = :user LIMIT 1");
        $query->execute([':user' => $login]);
        if ($query->fetch() != false) {
            return ['status' => 'error', 'message' => 'Username {$login} already exists'];
        }

        return ['status' => 'success'];
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

    public function search($term): object
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

    public function prune(): array
    {
        try {
            $this->db->exec('DROP TABLE IF EXISTS user');
        } catch (PDOException $e) {
            return ["status" => "error", "message" => "Error dropping table: " . $e->getMessage()];
        }

        if (file_exists(SQL_FILE)) {
            $ts = time();
            $hash = md5(uniqid(rand(), TRUE));
            $sql = file_get_contents(SQL_FILE);
            $sql = str_replace('{{TEMPID}}',"{$hash}", $sql);
            $sql = str_replace('{{CREATED}}',"{$ts}", $sql);
            try {
                $this->db->exec($sql);
            } catch (PDOException $e) {
                return ["status" => "error", "message" => "Exception: " . $e->getMessage()];
            }
        } else {
            return ["status" => "error", "message" => "Database pruned, but file " . SQL_FILE . " not found."];
        }

        return ["status" => "success", "message" => "Database pruned & created."];
    }
}