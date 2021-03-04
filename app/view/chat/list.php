<main role="main" class="container pb-4">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chat</li>
        </ol>
    </nav>

    <h1>Chat</h1>
    <div class="card">
        <div class="card-body" style=" width: 100%; height: 200px; max-height: 200px; display: -webkit-flex; display: flex; -webkit-flex-flow: column nowrap; flex-flow: column nowrap;">
            <div style="width: 100%; overflow-y: scroll; flex: 1 auto; height: 100%;">
            <?php
                if (isset($messages)) {
                    foreach ($messages as $message) {
                        echo $message->message . '<br />';
                    }
                }
                ?>
            </div>
        </div>
        <div class="card-footer">
            <form action="<?php echo URL; ?>chat/send" method="post">
                <div class="input-group m-0">
                    <input name="message" type="text" class="form-control" placeholder="Fale alguma coisa..." aria-label="Fale alguma coisa..." aria-describedby="button-addon">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</main>
