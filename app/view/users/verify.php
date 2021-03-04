<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users">Users</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users/login">Login</a></li>
            <li class="breadcrumb-item active" aria-current="page">Verify</li>
        </ol>
    </nav>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12 col-md-4">
                <h1>Verify</h1>

                <?php if (isset($result['message'])) { ?>
                    <div class="alert alert-primary" role="alert"><?php echo $result['message']; ?></div>
                <?php } ?>

                <form class="form-inline" action="<?php echo URL; ?>users/verify" method="post">
                    <label for="verify" class="sr-only">Verification Code</label>
                    <input name="verify" type="text" class="form-control mb-3 mr-1" id="verify" placeholder="Verification Code" value="<?php echo $hash ?? ''; ?>" required />
                    <button name="submit_verify_user" type="submit" class="btn btn-primary mb-2">Verify</button>
                    <a href="<?php echo URL; ?>users/reset" class="btn btn-danger mb-2">Re-send</a>
                </form>
            </div>
        </div>
    </div>
</main>

