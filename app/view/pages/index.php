<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item">Pages</li>
            <li class="breadcrumb-item active" aria-current="page">Help</li>
        </ol>
    </nav>

    <h1>About</h1>
    <p class="lead">
        This is a simple demonstration project.<br /><br />
        The user with admin role is <span class="font-weight-bold">admin</span> and the password is <span class="font-weight-bold">admin</span>, for other users the password is <span class="font-weight-bold">password</span>.<br /><br />
        1- Go to: <a href="<?php echo FULL_URL; ?>users/prune"><?php echo FULL_URL; ?>users/prune</a><br />
        2- Go to: <a href="<?php echo FULL_URL; ?>users/login"><?php echo FULL_URL; ?>users/login</a><br /><br />
        Thank you and enjoy.
    </p>
</main>

<div aria-live="polite" aria-atomic="true" class="position-relative">
    <!-- Position it: -->
    <!-- - `.toast-container` for spacing between toasts -->
    <!-- - `.position-absolute`, `top-0` & `end-0` to position the toasts in the upper right corner -->
    <!-- - `.p-3` to prevent the toasts from sticking to the edge of the container  -->
    <div class="toast-container position-absolute top-0 end-0 p-3">

        <!-- Then put toasts within -->
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="..." class="rounded me-2" alt="...">
                <strong class="me-auto">Bootstrap</strong>
                <small class="text-muted">just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                See? Just like this.
            </div>
        </div>

        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="..." class="rounded me-2" alt="...">
                <strong class="me-auto">Bootstrap</strong>
                <small class="text-muted">2 seconds ago</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Heads up, toasts will stack automatically
            </div>
        </div>
    </div>
</div>
