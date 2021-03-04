<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users">Users</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users/login">Login</a></li>
            <li class="breadcrumb-item active" aria-current="page">Reset</li>
        </ol>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                <h1>Reset password</h1>
                <?php if (isset($result['message'])) { ?>
                    <div class="alert alert-primary" role="alert">
                        <?php echo $result['message']; ?>
                    </div>
                <?php } ?>
                <form class="form-inline" action="<?php echo URL; ?>users/verify" method="post">
                    <div class="form-group mb-2 mr-2">
                        <label for="verify" class="sr-only">E-mail</label>
                        <input name="verify" type="text" class="form-control" id="verify" placeholder="E-mail" value="" required />
                    </div>
                    <button name="submit_reset_user" type="submit" class="btn btn-primary mb-2">Reset</button>
                </form>
            </div>
        </div>
    </div>
</main>

