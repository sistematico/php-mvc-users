<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Login</li>
        </ol>
    </nav>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12 col-md-4">
                <h1>Login</h1>

                <?php if (isset($result->message)) { ?>
                    <div class="alert alert-primary" role="alert"><?php echo $result->message; ?></div>
                <?php } ?>

                <form action="<?php echo URL; ?>users/login" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail address</label>
                        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Email or login" value="<?php if (isset($_POST['email'])) { echo $_POST['email']; } ?>">
                        <div id="emailHelp" class="form-text">
                            We'll never share your email with anyone else.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" id="password" aria-describedby="passwordHelp">
                        <small id="passwordHelp" class="form-text text-muted mb-3">
                            Before login, please check your e-mail and/or <a href="<?php echo URL; ?>users/verify">verify</a> your account.
                        </small>
                    </div>
                    <div class="mb-3">
                        <a href="<?php echo URL; ?>users/reset">Reset</a> your password or <a href="<?php echo URL; ?>users/verify">verify</a> your account.</a>
                    </div>
                    <div class="mb-3 form-check">
                        <input id="remember" class="form-check-input" name="remember" type="checkbox" value="remember" <?php if (isset($_POST['remember'])) { echo 'checked'; } ?>>
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <button name="submit_login_user" type="submit" class="btn btn-lg btn-primary">Sign in</button>
                </form>

                    <input name="email" type="text" id="email" class="form-control mb-3" placeholder="Email or login" value="<?php if (isset($_POST['email'])) { echo $_POST['email']; } ?>">
                    <label for="password" class="sr-only">Password</label>
                    <input name="password" type="password" id="password" class="form-control" placeholder="Password"  value="<?php if (isset($_POST['password'])) { echo $_POST['password']; } ?>">


            </div>
        </div>
    </div>
</main>

