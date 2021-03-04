<?php

namespace App\Model;

use App\Core\Model;

use PDOException;

class User extends Model
{
    private array $results = [];

    public function login($email, $password, $remember): array
    {
        $sql = "SELECT id, user, email, role, temp, password, valid FROM " . USERS_TABLE . " WHERE email LIKE :email OR user LIKE :email LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute([':email' => $email]);

        if (!$result = $query->fetch()) {
            return ['status' => 'error', 'class' => 'danger', 'message' => 'User not found.'];
        }

        if (isset($result->valid) && $result->valid == 0) {
            if (MODE === 'development') {
                return ['status' => 'error', 'class' => 'danger', 'error_code' => 'validate', 'message' => 'Validate your account first.', 'hash_code' => $result->temp];
            } else {
                return ['status' => 'error', 'class' => 'danger', 'error_code' => 'validate', 'message' => 'Validate your account first.'];
            }
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

            return ['status' => 'success', 'class' => 'success', 'message' => "User {$result->user} logged in."];
        } else {
            return ['status' => 'error', 'class' => 'danger', 'message' => "User / E-mail {$email} not found."];
        }
    }

    public function signup($login, $email, $password): array
    {
        $check = $this->check($login,$email);

        if ($check['status'] === 'error')
            return $check;

        $ts = time();
        $hash = md5(uniqid(rand(), TRUE));
        unset($_SESSION['last_message'], $_SESSION['last_class']);

        try {
            $query = $this->db->prepare("INSERT INTO " . USERS_TABLE . " (user, email, role, password, temp, valid, access, created) VALUES (:user, :email, :role, :password, :temp, :valid, :access, :created)");
            $query->execute([':user' => $login, ':email' => $email, ':role' => 'user', ':password' => password_hash($password, PASSWORD_DEFAULT), ':temp' => $hash, ':valid' => 0, ':access' => null, ':created' => $ts]);
        } catch (PDOException $e) {
            unset($e);
            if (MODE !== 'development') {
                if (!Mail::send($email, $login, 'Error inserting hash', 'Error sending hash! Re-send please.')) {
                    return ['status' => 'error', 'class' => 'danger', 'message' => "Error sending e-mail."];
                }
            }
            return ['status' => 'error', 'class' => 'danger', 'message' => "Error adding user {$login}"];
        }

        if (MODE === 'development') {
            return ['status' => 'error', 'class' => 'success', 'message' => "Success adding user <strong>${login}</strong>.<br />Verification e-mail NOT sent to <strong>{$email}</strong>,<br /> Hash: <strong>{$hash}</strong>"];
        } else {
            if (!Mail::sendHash($email, $login, $hash)) {
                return ['status' => 'error', 'class' => 'danger', 'message' => "Error sending e-mail to {$email}"];
            }
            return [
                'status' => 'error', 'class' => 'success',
                'message' => "Success adding user ${login}, verification e-mail sent to {$email}"
            ];
        }
    }

    public function reset($email): array
    {
        if ($user = $this->getUserId($email)) {
            if (MODE !== 'development') {
                if (!Mail::sendHash($user->email, $user->user, $user->hash)) {
                    return ['status' => 'error', 'class' => 'danger', 'message' => "Error sending e-mail to {$user->email}"];
                }
                return [
                    'status' => 'error', 'class' => 'success',
                    'message' => "Success resetting user $user->user , verification e-mail sent to {$user->email}."
                ];
            } else  {
                return [
                    'status' => 'error', 'class' => 'success',
                    'message' => "Success resetting user {$user->user} password verification e-mail NOT sent to {$user->email}.<br />New Hash: <strong>{$user->hash}</strong>"
                ];
            }
        } else {
            return ['status' => 'error', 'class' => 'danger', 'message' => 'Error resetting password.'];
        }
    }

    public function verify($hash): array
    {
        $query = $this->db->prepare("SELECT id, user, email, password, role, temp, valid FROM " . USERS_TABLE . " WHERE temp = :hash LIMIT 1");
        $query->execute([':hash' => $hash]);

        if (!$user = $query->fetch()) {
            return ["status" => "error", "message" => "Invalid code"];
        } else if ($user->valid == 1) {
            return ['status' => 'error', 'class' => 'danger', 'message' => "{$user->email} already validated"];
        } else if ($user->id && $hash === $user->temp) {
            $this->validate($user->id);
            return ['status' => 'error', 'class' => 'success', 'message' => "{$user->email} successful validated"];
        }
        return ['status' => 'error', 'class' => 'danger', 'message' => 'Undefined error.'];
    }

    public function list(): object
    {
        $query = $this->db->prepare("SELECT id, user, email, role, password, temp, valid, access, created FROM " . USERS_TABLE . "");
        $query->execute();
        while ($row = $query->fetch()) {
            $this->results[] = $row;
        }
        return (object) $this->results;
    }

    public function delete($id)
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] != 'admin') {
            if (isset($_SESSION['id']) && $id != $_SESSION['id']) {
                return ['status' => 'error', 'class' => 'danger', 'message' => '2 You don\'t have permissions to delete this account!'];
            }

            return ['status' => 'error', 'class' => 'danger', 'message' => '1 You don\'t have permissions to delete this account!'];
        }

        if ($id === 1) {
            return ['status' => 'error', 'class' => 'danger', 'message' => 'You cannot delete admin account!'];
        }

        try {
            $sql = "DELETE FROM " . USERS_TABLE . " WHERE id = :id";
            $query = $this->db->prepare($sql);
            $query->execute([':id' => $id]);
        } catch (PDOException $e) {
            return ['status' => 'error', 'class' => 'danger', 'message' => "Error deleting user id: {$id}"];
        }

        if ($_SESSION['id'] == $id) {
            unset($_COOKIE['id'], $_COOKIE['user'], $_COOKIE['role'], $_SESSION['logged'], $_SESSION['id'], $_SESSION['user'], $_SESSION['role']);
            setcookie("id", "", time() - 3600);
            setcookie("user", "", time() - 3600);
        }

        return ['status' => 'success', 'class' => 'success', 'message' => "User ID: {$id} deleted."];
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

    public function getUserId($email): bool
    {
        try {
            $query = $this->db->prepare("SELECT id, user, email, role, temp, valid FROM " . USERS_TABLE . " WHERE email = :email OR user = :email LIMIT 1");
            $query->execute([':email' => $email]);
            return $query->fetch();
        } catch (PDOException $e) {
            unset($e);
            return false;
        }
    }

    public function update($login, $email, $role, $id, $valid, $password)
    {
        $_SESSION['user'] = $login;
        
        $sql = "UPDATE " . USERS_TABLE . " SET user = :user, email = :email, role = :role, valid = :valid WHERE id = :id";
        $params = [':user' => $login, ':email' => $email, ':role' => $role, ':valid' => $valid, ':id' => $id];
        
        if ($password != null && strlen($password) > 0) {
            $temp = md5(uniqid(rand(), TRUE));
            $sql = "UPDATE " . USERS_TABLE . " SET user = :user, email = :email, role = :role, password = :password, temp = :temp, valid = :valid WHERE id = :id";
            $params = [':user' => $login, ':email' => $email, ':role' => $role, ':password' => password_hash($password, PASSWORD_DEFAULT), ':temp' => $temp, ':valid' => $valid, ':id' => $id];
        }

        try {
            $query = $this->db->prepare($sql);
            $query->execute($params);
        } catch (PDOException $e) {
            return ['status' => 'error', 'class' => 'danger', 'message' => "Error editing user {$login}: " . $e->getMessage()];
        }

        return ['status' => 'error', 'class' => 'success', 'message' => "User {$login} sucessfull updated."];
    }

    public function access($id)
    {
        $query = $this->db->prepare("UPDATE " . USERS_TABLE . " SET access = :access WHERE id = :id");
        $query->execute([':id' => $id, ':access' => time()]);
    }

    public function validate($id)
    {
        $sql = "UPDATE " . USERS_TABLE . " SET temp = :hash, valid = :valid WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute([':hash' => md5(uniqid(rand(), TRUE)), ':valid' => 1, ':id' => $id]);
    }

    public function amount()
    {
        $sql = "SELECT COUNT(id) AS amount FROM " . USERS_TABLE . ";";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch()->amount;
    }

    public function search($term): object
    {
        $term = "%" . $term . "%";
        $sql = "SELECT id, user, email, role, temp, valid, access, created FROM " . USERS_TABLE . " WHERE email LIKE :term OR user LIKE :term";
        $query = $this->db->prepare($sql);
        $query->execute([':term' => $term]);
        while ($row = $query->fetch()) {
            $this->results[] = $row;
        }
        return (object) $this->results;
    }

    public function check($login, $email): array
    {
        $query = $this->db->prepare("SELECT id FROM " . USERS_TABLE . " WHERE email = :email LIMIT 1");
        $query->execute([':email' => $email]);

        if ($query->fetch() !== false) {
            return ['status' => 'error', 'class' => 'danger', 'message' => "E-mail {$email} already exists"];
        }

        $query = $this->db->prepare("SELECT id FROM " . USERS_TABLE . " WHERE user = :user LIMIT 1");
        $query->execute([':user' => $login]);
        if ($query->fetch() != false) {
            return ['status' => 'error', 'class' => 'danger', 'message' => "Username {$login} already exists"];
        }

        return ['status' => 'error', 'class' => 'success', 'message' => "Username and email not exist in our database."];
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
            $sql = str_replace('{{USERS_TABLE}}',USERS_TABLE, $sql);
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