<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Signup</li>
        </ol>
    </nav>

    <div class="container text-center">
        <div class="row justify-content-md-center">
            <div class="col-4">
                <h1>Signup</h1>
                <?php if (isset($result)) { ?>
                    <div class="alert alert-primary" role="alert"><?php echo $result; ?></div>
                <?php } ?>
                <form class="form-signin" action="<?php echo URL; ?>users/signup" method="post">
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                    <input name="submit_signup_user" type="submit" class="btn btn-lg btn-primary btn-block" value="Signup">
                </form>
            </div>
        </div>
    </div>
</main>

