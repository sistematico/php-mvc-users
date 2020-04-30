<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Verify</li>
        </ol>
    </nav>

    <h1>Users</h1>
    <h3>Verify a user</h3>

    <?php if (isset($result)) { ?>
        <div class="alert alert-primary" role="alert"><?php var_dump($result); ?></div>
    <?php } ?>

    <form class="form-inline" action="<?php echo URL; ?>users/verify" method="post">
        <div class="form-group mb-2 mr-2">
            <label for="verify" class="sr-only">Verification Code</label>
            <input name="verify" type="text" class="form-control" id="verify" placeholder="Verification Code" value="" required />
        </div>
        <button name="submit_verify_user" type="submit" class="btn btn-primary mb-2">Verify</button>
    </form>
</main>

