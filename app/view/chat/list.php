<main role="main" class="container pb-4">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chat</li>
        </ol>
    </nav>

    <h1>Chat</h1>

    <?php
        if (isset($messages)) {
            foreach ($messages as $message) {
                echo $message['message'];
            }
        }
    ?>

    <form action="<?php echo URL; ?>chat/send" method="post">
        <div class="input-group mb-3">
            <input name="message" type="text" class="form-control" placeholder="Fale alguma coisa..." aria-label="Fale alguma coisa..." aria-describedby="button-addon">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon">Enviar</button>
        </div>
    </form>
</main>
