<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item">Pages</li>
            <li class="breadcrumb-item active" aria-current="page">Help</li>
        </ol>
    </nav>

    <h1>About</h1>
    <p class="lead">
        This is a simple demonstration project.<br /><br />
        The user with admin role is <span class="fw-bold">admin</span> and the password is <span class="fw-bold">admin</span>, for other users the password is <span class="fw-bold">password</span>.<br /><br />
        1- Rename <span class="fw-bold">.env.example</span> to <span class="fw-bold">.env</span> in project root folder.<br />
        2- Go to: <a href="<?php echo FULL_URL; ?>users/prune"><?php echo FULL_URL; ?>users/prune</a><br />
        3- Go to: <a href="<?php echo FULL_URL; ?>users/login"><?php echo FULL_URL; ?>users/login</a><br /><br />
        Thank you and enjoy.
    </p>
</main>