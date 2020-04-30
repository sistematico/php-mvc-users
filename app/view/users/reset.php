<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reset</li>
        </ol>
    </nav>

    <h1>Users</h1>
    <h3>Reset password</h3>

    <?php 
        if (isset($result)) { 
            $code = explode(' ',trim($result));
    ?>
        <div class="alert alert-primary" role="alert"><?php echo $result; ?></div>
    <?php } ?>

    <form class="form-inline" action="<?php echo URL; ?>users/verify" method="post">
        <div class="form-group mb-2 mr-2">
            <label for="verify" class="sr-only">E-mail</label>
            <input name="verify" type="text" class="form-control" id="verify" placeholder="E-mail" value="" <?php echo (isset($code) && $code[1] == 'sucessful' ? 'disabled' : 'required'); ?> />
        </div>
        <button name="submit_reset_user" type="submit" class="btn btn-primary mb-2" <?php echo (isset($code) && $code[1] == 'sucessful' ? 'disabled' : ''); ?>>Reset</button>
    </form>
</main>

