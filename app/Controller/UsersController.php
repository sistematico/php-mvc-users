<?php

namespace App\Controller;

use App\Model\User;

class UsersController
{
    public $status = '';

    public function index()
    {
        $User = new User();
        if ($User->tableExists() !== true) {
            $User->prune();
        }
        //$users = $User->list();
        //$amount = $User->amount();
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
                    //$user = $User->get($id);
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
        if (!isset($_SESSION['logged'])) {
            if (isset($_POST["submit_login_user"])) {
                $remember = isset($_POST['remember']);
                $User = new User();
                if ($User->login($_POST["email"], $_POST["password"], $remember)['status'] === 'success') {
                    require APP . 'view/_templates/header.php';
                    require APP . 'view/users/index.php';
                    require APP . 'view/_templates/footer.php';
                } else {
                    require APP . 'view/_templates/header.php';
                    require APP . 'view/users/login.php';
                    require APP . 'view/_templates/footer.php';
                }
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

    public function verify($hash = null)
    {
        if (!isset($_SESSION['logged'])) {
            $User = new User();

            if (isset($_POST["submit_verify_user"]) 
                && isset($_POST["verify"])
                && !empty($_POST["verify"])) {
                $hash = trim($_POST["verify"]);
            } 

            if ($hash) {
                $result = $User->verify(trim($hash));
            }
        } else {
            $result = "Logout first";
        }
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/verify.php';
        require APP . 'view/_templates/footer.php';
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

    public function logout()
    {
        setcookie("id", "", time() - 3600);
        setcookie("user", "", time() - 3600);
        unset($_COOKIE['id'], $_COOKIE['user'], $_COOKIE['role'], $_SESSION['logged'], $_SESSION['id'], $_SESSION['user'], $_SESSION['role']);
        header('location: ' . URL);
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
        if (isset($_POST["submit_update_user"]) &&
            isset($_POST["id"])        
        ) {
            $User = new User();
            $password = (isset($_POST["password"]) ? $_POST["password"] : null);
            $valid = isset($_POST['valid']) && $_POST['valid'] == 'sim' ? 1 : 0; 

            $User->update($_POST["login"], $_POST["email"], $_POST["role"], $_POST['id'], $valid, $password);
            //var_dump($_POST['valid']);
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
