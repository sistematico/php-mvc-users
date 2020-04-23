<main role="main" class="container">
    <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Home</li>
        </ol>
    </nav>

    <h1>Home</h1>
    <p class="lead">
        <?php if (!isset($_SESSION['logged'])) { ?>
            <a class="btn btn-primary m-1" href="<?php echo URL; ?>users/login" role="button">Login</a>
            <a class="btn btn-primary m-1" href="<?php echo URL; ?>users/signup" role="button">Signup</a>
        <?php } else { ?>
            <a class="btn btn-primary m-1" href="<?php echo URL; ?>users/logout" role="button">Logout</a>
        <?php } ?>
        <a class="btn btn-primary m-1" href="<?php echo URL; ?>users" role="button">List Users</a>
        <a class="btn btn-danger m-1" href="<?php echo URL; ?>users/prune" role="button">Prune Table</a>
        <a class="btn btn-info m-1" href="<?php echo URL; ?>users/populate" role="button">Populate Songs</a>
    </p>
</main>
