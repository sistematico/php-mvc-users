<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2">
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

                <?php 
                    if (isset($result)) { 
                        $code = explode(' ',trim($result));
                        //logged
                ?>
                    <div class="alert alert-primary" role="alert"><?php echo $result; ?></div>
                <?php } ?>

                <form class="form-signin" action="<?php echo URL; ?>users/login" method="post">
                    <label for="inputEmail" class="sr-only">Email or Login</label>
                    <input name="email" type="text" id="email" class="form-control mb-3" placeholder="Email or login" <?php echo (isset($code) && $code[2] == 'logged' ? 'disabled' : 'required autofocus'); ?>>
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input name="password" type="password" id="password" class="form-control" placeholder="Password" aria-describedby="passwordHelp" <?php echo (isset($code) && $code[2] == 'logged' ? 'disabled' : 'required'); ?>>
                    <small id="passwordHelp" class="form-text text-muted mb-3">
                        Before login, please check your e-mail and/or <a href="<?php echo URL; ?>users/verify">verify</a> your account.
                    </small>

                    <div class="checkbox mb-3">
                        <label>
                            <input name="remember" type="checkbox" value="remember"> Remember me
                        </label>
                    </div>
                    <input name="submit_login_user" type="submit" class="btn btn-lg btn-primary" value="Sign in">
                </form>
            </div>
        </div>
    </div>
</main>

