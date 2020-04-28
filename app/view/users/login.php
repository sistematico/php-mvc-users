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
            <div class="col-4">
                <h1>Login</h1>
                <?php if (isset($result)) { ?>
                    <div class="alert alert-primary" role="alert"><?php echo $result; ?></div>
                <?php } ?>
                <form class="form-signin" action="<?php echo URL; ?>users/login" method="post">
                    <label for="inputEmail" class="sr-only">Email or Login</label>
                    <input name="email" type="text" id="inputEmail" class="form-control m-3" placeholder="Email or login" required autofocus>
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input name="password" type="password" id="inputPassword" class="form-control m-3" placeholder="Password" required>
                    <div class="checkbox m-3">
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

