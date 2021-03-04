<?php

namespace App\Controller;

use App\Model\User;

class UsersController
{
    public function index()
    {
        $User = new User();
        $users = $User->list();
        $amount = $User->amount();
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function profile($id)
    {
        if (isset($id) && is_numeric($id)) {
           $User = new User();
           $user = $User->get($id);
        }
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/profile.php';
        require APP . 'view/_templates/footer.php';
    }

    public function prune()
    {
        $User = new User();
        $toast = $User->prune();
        require APP . 'view/_templates/header.php';
        require APP . 'view/pages/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function login()
    {
        $this->logged();

        if (isset($_POST["submit_login_user"])) {
            $remember = isset($_POST['remember']);
            $User = new User();
            $result = $User->login($_POST["email"], $_POST["password"], $remember);

            if ($result['status'] === 'success') {
                $toast = $result;
                require APP . 'view/_templates/header.php';
                require APP . 'view/pages/index.php';
                require APP . 'view/_templates/footer.php';
            } else if ($result['status'] === 'error' && isset($result['error_code']) && $result['error_code'] === 'validate') {
                if (MODE === 'development') {
                    $code = $result['hash_code'] ?? '';
                }
                require APP . 'view/_templates/header.php';
                require APP . 'view/users/verify.php';
                require APP . 'view/_templates/footer.php';
            } else {
                require APP . 'view/_templates/header.php';
                require APP . 'view/users/login.php';
                require APP . 'view/_templates/footer.php';
            }
        } else {
            require APP . 'view/_templates/header.php';
            require APP . 'view/users/login.php';
            require APP . 'view/_templates/footer.php';
        }
    }

    public function logout()
    {
        $User = new User();
        $toast = $User->logout();

        // setcookie('id', '', time() - 3600);
        // setcookie('user', '', time() - 3600);
        // unset($_COOKIE['id'], $_COOKIE['user'], $_COOKIE['role'], $_SESSION['logged'], $_SESSION['id'], $_SESSION['user'], $_SESSION['role']);

        require APP . 'view/_templates/header.php';
        require APP . 'view/pages/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function signup()
    {
        $this->logged();

        if (isset($_POST["submit_signup_user"])) {
            $User = new User();
            $result = $User->signup($_POST["login"], $_POST["email"], $_POST["password"]);
            $toast = $result;

            if ($result['status'] === 'success' && MODE !== 'development') {
                require APP . 'view/_templates/header.php';
                require APP . 'view/pages/index.php';
                require APP . 'view/_templates/footer.php';
            } else {
                require APP . 'view/_templates/header.php';
                require APP . 'view/users/signup.php';
                require APP . 'view/_templates/footer.php';
            }
        } else {
            require APP . 'view/_templates/header.php';
            require APP . 'view/users/signup.php';
            require APP . 'view/_templates/footer.php';
        }
    }

    public function verify($hash = null)
    {
        if (isset($_SESSION['logged'])) {
            header('location: ' . URL);
        }

        if (isset($_POST["submit_verify_user"]) && isset($_POST["verify"]) && !empty($_POST["verify"])) {
            $User = new User();
            $result = $User->verify(trim($_POST["verify"]));
        } else if ($hash) {
            $User = new User();
            $result = $User->verify(trim($hash));
        }

        if (isset($result['status']) && $result['status'] === 'success') {
            require APP . 'view/_templates/header.php';
            require APP . 'view/users/login.php';
            require APP . 'view/_templates/footer.php';
        } else {
            require APP . 'view/_templates/header.php';
            require APP . 'view/users/verify.php';
            require APP . 'view/_templates/footer.php';
        }
    }

    public function reset()
    {
        if (isset($_POST["submit_reset_user"])) {
            $User = new User();
            $result = $User->reset($_POST['email']);
        }
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/reset.php';
        require APP . 'view/_templates/footer.php';
    }

    public function delete($id)
    {
        $User = new User();

        if (isset($id)) {
            $toast = $User->delete((int) $id);
        }

        $users = $User->list();
        $amount = $User->amount();

        require APP . 'view/_templates/header.php';
        require APP . 'view/users/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $_POST;
        } else if (isset($id)) {
            $User = new User();
            $user = $User->get($id);
        }
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/edit.php';
        require APP . 'view/_templates/footer.php';
    }

    public function update()
    {
        if (isset($_POST["submit_update_user"]) && isset($_POST["id"])) {
            $User = new User();
            $password = (isset($_POST["password"]) ? $_POST["password"] : null);
            $valid = isset($_POST['valid']) && $_POST['valid'] == 'sim' ? 1 : 0; 
            $result = $User->update($_POST["user"], $_POST["email"], $_POST["role"], $_POST['id'], $valid, $password);
        }

        if (isset($result['status']) && $result['status'] === 'success') {
            $toast = $result;
            require APP . 'view/_templates/header.php';
            require APP . 'view/users/index.php';
            require APP . 'view/_templates/footer.php';
        } else {
            require APP . 'view/_templates/header.php';
            require APP . 'view/users/edit.php';
            require APP . 'view/_templates/footer.php';
        }
    }

    public function search()
    {
        if (isset($_POST["term"]) && strlen($_POST["term"]) > 1) {
            $User = new User();
            $users = $User->search($_POST["term"]);
        } 
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/search.php';
        require APP . 'view/_templates/footer.php';
    }

    public function logged()
    {
        if (isset($_SESSION['logged'])) {
            $_SESSION['last_message'] = 'You are already logged in.';
            $_SESSION['last_class'] = 'text-white bg-warning';
            header('location: ' . URL);
        }
    }

    public function notLogged()
    {
        if (!isset($_SESSION['logged'])) {
            $_SESSION['last_message'] = 'You are not logged in.';
            $_SESSION['last_class'] = 'text-white bg-warning';
            header('location: ' . URL);
        }
    }
}
