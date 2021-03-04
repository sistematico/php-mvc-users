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

    public function send(string $message)
    {
        $Chat = new Chat();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $Chat->send($_POST['message']);
        }

        $messages = $Chat->list();

        require APP . 'view/_templates/header.php';
        require APP . 'view/chat/list.php';
        require APP . 'view/_templates/footer.php';
    }
}
