<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Signup</li>
        </ol>
    </nav>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12 col-md-4">
                <h1>Signup</h1>
                <?php if (isset($result['message'])) { ?>
                    <div class="alert alert-primary" role="alert"><?php echo $result['message']; ?></div>
                <?php } ?>

                <form action="<?php echo URL; ?>users/signup" method="post">
                    <div class="mb-3">
                        <label for="login" class="form-label">Username</label>
                        <input name="login" type="text" class="form-control" id="login" placeholder="Username" value="<?php echo $_POST['login'] ?? ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Username" value="<?php echo $_POST['email'] ?? ''; ?>">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="Password" value="<?php echo $_POST['password'] ?? ''; ?>">
                        <small id="passwordHelp" class="form-text text-muted mb-3">
                            <a href="<?php echo URL; ?>users/login">Login</a> if you already have an account.
                        </small>
                    </div>

                    <button name="submit_signup_user" type="submit" class="btn btn-lg btn-primary">Signup</button>
                </form>
            </div>
        </div>
    </div>
</main>

