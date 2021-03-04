<?php

namespace App\Controller;

use App\Model\User;
use App\Helper\Log;

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
        $User->prune();
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function login()
    {
        $this->logged();

        if (isset($_POST["submit_login_user"])) {
            $remember = isset($_POST['remember']);
            $User = new User();
            $result = json_decode($User->login($_POST["email"], $_POST["password"], $remember));

            if ($result->status === 'success') {
                require APP . 'view/_templates/header.php';
                require APP . 'view/pages/index.php';
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
        setcookie("id", "", time() - 3600);
        setcookie("user", "", time() - 3600);
        unset($_COOKIE['id'], $_COOKIE['user'], $_COOKIE['role'], $_SESSION['logged'], $_SESSION['id'], $_SESSION['user'], $_SESSION['role']);

        if (isset($_SESSION['logged']) && isset($_SESSION['user'])) {
            $response = (object) ['status' => 'success', 'message' => "User {$_SESSION['user']} has logged off successfully."];
        } else {
            $response = (object) ['status' => 'error', 'message' => "You not logged."];
        }

        require APP . 'view/_templates/header.php';
        require APP . 'view/pages/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function signup()
    {
        $this->logged();

        if (isset($_POST["submit_signup_user"])) {
            $User = new User();
            $result = json_decode($User->signup($_POST["login"], $_POST["email"], $_POST["password"]));

            if ($result->status === 'success') {
                require APP . 'view/_templates/header.php';
                require APP . 'view/users/index.php';
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
            $result = json_decode($User->verify(trim($_POST["verify"])));
        } else if ($hash) {
            $User = new User();
            $result = json_decode($User->verify(trim($hash)));
        }

        require APP . 'view/_templates/header.php';
        require APP . 'view/users/verify.php';
        require APP . 'view/_templates/footer.php';
    }

    public function reset()
    {
        if (isset($_POST["submit_reset_user"])) {
            $User = new User();
            $result = json_encode($User->reset($_POST['email']));
        }
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/reset.php';
        require APP . 'view/_templates/footer.php';
    }

    public function confirm()
    {
        if (isset($_POST["submit_confirm_user"])) {
            $User = new User();
            $result = json_decode($User->confirm($_POST['email']));
        }
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/reset.php';
        require APP . 'view/_templates/footer.php';
    }

    public function delete($id)
    {
        if (isset($id)) {
            if (isset($_SESSION['id']) && $id == $_SESSION['id'] || isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                $User = new User();
                $User->delete($id);

                if ($_SESSION['id'] == $id) {
                    unset($_COOKIE['id'], $_COOKIE['user'], $_COOKIE['role'], $_SESSION['logged'], $_SESSION['id'], $_SESSION['user'], $_SESSION['role']);
                    setcookie("id", "", time() - 3600);
                    setcookie("user", "", time() - 3600);
                }
            }    
        }
        header('location: ' . URL . 'users/index');
    }

    public function edit($id)
    {
        if (isset($id)) {
            if (isset($_SESSION['id']) && $id == $_SESSION['id'] || isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                $User = new User();
                $user = $User->get($id);

                if ($user === false) {
                    $page = new \App\Controller\PagesController();
                    $page->error();
                } else {
                    require APP . 'view/_templates/header.php';
                    require APP . 'view/users/edit.php';
                    require APP . 'view/_templates/footer.php';
                } 
            } else {
                header('location: ' . URL);
            }
        } else {
            header('location: ' . URL . 'users/index');
        }
    }

    public function update()
    {
        if (isset($_POST["submit_update_user"]) && isset($_POST["id"])) {
            $User = new User();
            $password = (isset($_POST["password"]) ? $_POST["password"] : null);
            $valid = isset($_POST['valid']) && $_POST['valid'] == 'sim' ? 1 : 0; 
            $User->update($_POST["login"], $_POST["email"], $_POST["role"], $_POST['id'], $valid, $password);
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
            header('location: ' . URL);
        }
    }
}
