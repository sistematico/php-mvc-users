<?php

namespace App\Controller;

use App\Model\User;

class UsersController
{
    public function index()
    {
        $User = new User();
        if ($User->tableExists() === true) {
            $users = $User->list();
            $amount = $User->amount();
        } else {
            $result = $User->prune();
        }
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function profile($id)
    {
        if (isset($id)) {
            if (isset($_SESSION['logged']) && isset($_SESSION['id']) && $id == $_SESSION['id']) {
                if ($id == $_SESSION['id']) {
                    $User = new User();
                    $user = $User->get($id);
                } else if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                    $result = "Forbidden operation";
                }
            } else {
                $result = "User must be logged";
            }
        } 
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/profile.php';
        require APP . 'view/_templates/footer.php';
    }

    public function verify($hash = null)
    {
        if (!isset($_SESSION['logged'])) {
            if (isset($_POST["submit_verify_user"]) && isset($_POST["verify"])) {
                $hash = $_POST["verify"];
            }

            if ($hash !== null) {
                $User = new User();
                $result = $User->verify(trim($hash));
            }
        }
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/verify.php';
        require APP . 'view/_templates/footer.php';
    }

    public function prune()
    {
        $User = new User();
        $result = $User->prune();
        $users = $User->list();
        $amount = $User->amount();
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function login()
    {
        if (!isset($_SESSION['logged'])) {
            if (isset($_POST["submit_login_user"])) {
                $remember = (isset($_POST['remember']) ? true : false);
                $User = new User();
                $result = $User->login($_POST["email"], $_POST["password"], $remember);
            }
            require APP . 'view/_templates/header.php';
            require APP . 'view/users/login.php';
            require APP . 'view/_templates/footer.php';
        } else {
            header('location: ' . URL);
        }
    }

    public function signup()
    {
        if (!isset($_SESSION['logged'])) {
            if (isset($_POST["submit_signup_user"])) {
                $User = new User();
                $result = $User->signup($_POST["login"], $_POST["email"], $_POST["password"]);
            }
            require APP . 'view/_templates/header.php';
            require APP . 'view/users/signup.php';
            require APP . 'view/_templates/footer.php';
        } else {
            header('location: ' . URL);
        }
    }

    public function logout()
    {
        unset($_COOKIE['id'], $_COOKIE['user'], $_COOKIE['role'], $_SESSION['logged'], $_SESSION['id'], $_SESSION['user'], $_SESSION['role']);
        setcookie("id", "", time() - 3600);
        setcookie("user", "", time() - 3600);
        header('location: ' . URL);
    }

    public function delete($id)
    {
        if (isset($id)) {
            if (isset($_SESSION['id']) && $id == $_SESSION['id'] || isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                $User = new User();
                $User->delete($id);
                unset($_COOKIE['id'], $_COOKIE['user'], $_COOKIE['role'], $_SESSION['logged'], $_SESSION['id'], $_SESSION['user'], $_SESSION['role']);
                setcookie("id", "", time() - 3600);
                setcookie("user", "", time() - 3600);
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
        if (isset($_POST["submit_update_user"])) {
            $User = new User();
            $User->update($_POST["login"], $_POST["email"], $_POST["role"], $_POST['id'], $_POST['valid'], $_POST["password"] = null);
        }
        header('location: ' . URL . 'users');
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

    public function ajax()
    {
        $User = new User();
        $amount = $User->amount();
        echo $amount;
    }
}
