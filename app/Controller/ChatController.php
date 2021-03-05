<?php

namespace App\Controller;

use App\Model\Chat;

class ChatController
{
    public function index()
    {
        $Chat = new Chat();
        $messages = $Chat->list();

        require APP . 'view/_templates/header.php';
        require APP . 'view/chat/list.php';
        require APP . 'view/_templates/footer.php';
    }

    public function send()
    {
        $Chat = new Chat();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && !empty($_POST['message'])) {
            $Chat->send($_POST['message']);
        }

        $messages = $Chat->list();

        require APP . 'view/_templates/header.php';
        require APP . 'view/chat/list.php';
        require APP . 'view/_templates/footer.php';
    }

    public function isLogged()
    {
        if (isset($_SESSION['logged'])) {
            return true;
        }

        return false;
    }

    public function isAdmin()
    {
        if (isset($_SESSION['logged']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            return true;
        }
        return false;
    }
}
