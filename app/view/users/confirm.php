<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users">Users</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users">Login</a></li>
            <li class="breadcrumb-item active" aria-current="page">Confirm</li>
        </ol>
    </nav>

    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1>Confirm your account</h1>
                <?php if (isset($result->message)) { ?>
                    <div class="alert alert-primary" role="alert"><?php echo $result->message; ?></div>
                <?php } ?>
                <form class="form-inline" action="<?php echo URL; ?>users/confirm" method="post">
                    <div class="form-group mb-2 mr-2">
                        <label for="verify" class="sr-only">E-mail</label>
                        <input name="verify" type="text" class="form-control" id="verify" placeholder="E-mail" value="" required />
                    </div>
                    <div class="form-group mb-2 mr-2">
                        <label for="code" class="sr-only">Code</label>
                        <input name="code" type="text" class="form-control" id="code" placeholder="Code" value="" required />
                    </div>
                    <button name="submit_reset_user" type="submit" class="btn btn-primary mb-2">Confirm</button>
                    <a href="<?php echo URL; ?>users/reset" class="btn btn-danger mb-2">Re-send</a>
                    <a href="<?php echo URL; ?>users/login" class="btn btn-success mb-2">Login</a>
                </form>
            </div>
        </div>
    </div>
</main>

