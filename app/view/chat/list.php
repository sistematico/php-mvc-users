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
</main>
