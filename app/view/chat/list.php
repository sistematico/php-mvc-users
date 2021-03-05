<main class="flex-shrink-0">
    <div class="container overflow-hidden">
        <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chat</li>
            </ol>
        </nav>
        <h1>Chat</h1>
        <div class="card">
            <div class="card-body overflow-auto" style="height: auto">
                <?php
                if (isset($messages)) {
                    foreach ($messages as $message) {
                        echo $message->message . ((isset($_SESSION['role']) && $_SESSION['role'] === 'admin') ? '<a href="' . URL . 'chat/delete/' . $message->id . '">del</a><br />' : '');
                    }
                }
                ?>
            </div>
            <div class="card-footer">
                <form action="<?php echo URL; ?>chat/send" method="post">
                    <div class="input-group m-0">
                        <input name="message" type="text" class="form-control" placeholder="<?php echo isset($_SESSION['logged']) ? 'Fale alguma coisa...' : 'Você precisa fazer login para conversar!'; ?>" aria-label="Fale alguma coisa..." aria-describedby="button-addon" <?php echo isset($_SESSION['logged']) ? '' : 'disabled'; ?>>
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon" <?php echo isset($_SESSION['logged']) ? '' : 'disabled'; ?>>Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
