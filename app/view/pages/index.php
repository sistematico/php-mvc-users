<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Home</li>
        </ol>
    </nav>

    <h1>Index</h1>
    <p class="lead"><?php echo MODE; ?> Welcome...</p>
</main>

<?php if (isset($toast->message)) { ?>
<div aria-live="polite" aria-atomic="true" class="position-relative">
    <div class="toast-container position-absolute p-3 bottom-0 end-0">
        <div class="toast align-items-center border-0 <?php echo $toast->class ?? 'text-white bg-dark'; ?>" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo $toast->message; ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if (isset($_SESSION['last_message'])) { ?>
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-absolute p-3 bottom-0 end-0">
            <div class="toast align-items-center <?php echo $_SESSION['last_class'] ?? 'text-white bg-primary'; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $_SESSION['last_message']; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
<?php
unset($_SESSION['last_message'], $_SESSION['last_class']);
}
?>
