<?php

namespace App\Controller;

use App\Model\User;

class UsersController
{
    public function index()
    {
        $User = new User();
        if ($User->tableExists() !== true) {
            $User->install();
        }
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
                $User = new User();
                $result = $User->login($_POST["email"], $_POST["password"]);
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
                $result = $User->signup($_POST["email"], $_POST["password"]);
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
        unset($_SESSION['logged'],$_SESSION['id'],$_SESSION['role']);
        header('location: ' . URL);
    }

    public function deleteUser($id)
    {
        if (isset($id)) {
            $User = new User();
            $User->deleteUser($id);
        }
        header('location: ' . URL . 'users/index');
    }

    public function editUser($id)
    {
        if (isset($id)) {
            $User = new User();
            $user = $User->getUser($id);

            if ($user === false) {
                $page = new \App\Controller\PagesController();
                $page->error();
            } else {
                require APP . 'view/_templates/header.php';
                require APP . 'view/users/edit.php';
                require APP . 'view/_templates/footer.php';
            }
        } else {
            header('location: ' . URL . 'users/index');
        }
    }

    public function updateUser()
    {
        if (isset($_POST["submit_update_user"])) {
            $User = new User();
            $User->updateUser($_POST["email"], $_POST["password"], $_POST['id']);
        }
        header('location: ' . URL . 'users');
    }

    public function search()
    {
        if (isset($_POST["term"])) {
            $User = new User();
            $users = $User->searchUsers($_POST["term"]);
        } 
        require APP . 'view/_templates/header.php';
        require APP . 'view/users/search.php';
        require APP . 'view/_templates/footer.php';
    }

    public function ajaxGetStats()
    {
        $User = new User();
        $amount = $User->amount();
        echo $amount;
    }
}
