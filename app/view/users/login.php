<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Login</li>
        </ol>
    </nav>

    <div class="container text-center">
        <div class="row justify-content-md-center">
            <div class="col-5">
                <h1>Login</h1>

                <?php if (isset($result->message)) { ?>
                    <div class="alert alert-primary" role="alert"><?php echo $result->message; ?></div>
                <?php } ?>

                <form class="form-signin" action="<?php echo URL; ?>users/login" method="post">
                    <label for="email" class="sr-only">Email or Login</label>
                    <input name="email" type="text" id="email" class="form-control mb-3" placeholder="Email or login" value="<?php if (isset($_POST['email'])) { echo $_POST['email']; } ?>">
                    <label for="password" class="sr-only">Password</label>
                    <input name="password" type="password" id="password" class="form-control" placeholder="Password" aria-describedby="passwordHelp" value="<?php if (isset($_POST['password'])) { echo $_POST['password']; } ?>">
                    <small id="passwordHelp" class="form-text text-muted mb-3">
                        Before login, please check your e-mail and/or <a href="<?php echo URL; ?>users/verify">verify</a> your account.
                    </small>
                    <div class="checkbox mb-3">
                        <label>
                            <input name="remember" type="checkbox" value="remember" <?php if (isset($_POST['remember'])) { echo 'checked'; } ?>> Remember me
                        </label>
                    </div>

                    <div class="mb-3">
                        <a href="<?php echo URL; ?>users/reset">Reset your password</a>
                    </div>

                    <input name="submit_login_user" type="submit" class="btn btn-lg btn-primary" value="Sign in">
                </form>
            </div>
        </div>
    </div>
</main>

