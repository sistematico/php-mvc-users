<main role="main" class="container text-center">

    <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Verify</li>
        </ol>
    </nav>

    <div class="container text-center">
        <div class="row justify-content-md-center">
            <div class="col-5">
                <h1>Verify</h1>

                <?php 
                    if (isset($result)) { 
                        $code = explode(' ',trim($result));
                        //logged
                ?>
                    <div class="alert alert-primary" role="alert"><?php echo $result; ?></div>
                <?php } ?>

                <?php if (!isset($code) || $code[1] != 'sucessful') { ?>
                <form class="form-inline" action="<?php echo URL; ?>users/verify" method="post">
                    <label for="verify" class="sr-only">Verification Code</label>
                    <input name="verify" type="text" class="form-control mb-3 mr-1" id="verify" placeholder="Verification Code" value="" required />
                    <button name="submit_verify_user" type="submit" class="btn btn-primary mb-3">Verify</button>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
</main>

