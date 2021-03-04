<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Home</li>
        </ol>
    </nav>

    <h1>Index</h1>
    <p class="lead"><?php echo MODE; ?> Welcome...</p>
</main>

<?php if (isset($result->message)) { ?>
<div aria-live="polite" aria-atomic="true" class="position-relative <?php echo $toast->class ?? 'bg-dark'; ?>">
    <div class="toast-container position-absolute p-3 bottom-0 end-0">
        <div class="toast">
            <div class="toast-header">
                <img src="<?php echo URL; ?>img/silhouette.png" class="rounded me-2" alt="PHP MVC Users" height="18">
                <strong class="me-auto">PHP MVC Users</strong>
                <small>now</small>
            </div>
            <div class="toast-body">
                <?php echo $result->message; ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if (isset($_SESSION['LAST_MESSAGE'])) { ?>
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-absolute p-3 bottom-0 end-0">
            <div class="toast align-items-center <?php echo $_SESSION['LAST_CLASS'] ?? 'text-white bg-primary'; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $_SESSION['LAST_MESSAGE']; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
<?php
unset($_SESSION['LAST_MESSAGE'], $_SESSION['LAST_CLASS']);
}
?>
