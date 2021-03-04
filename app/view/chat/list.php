<main role="main" class="container pb-4">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chat</li>
        </ol>
    </nav>

    <h1>Chat</h1>

    <?php if (isset($users)) { ?>
    <div class="table-responsive">
    <table class="table table-striped table-dark">

        <tbody>
            <?php foreach ($users as $user) { ?>

            <?php } ?>
        </tbody>
    </table>
    </div>
    <?php } ?>
</main>
