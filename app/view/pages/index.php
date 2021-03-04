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
<div aria-live="polite" aria-atomic="true" class="bg-dark position-relative bd-example-toasts">
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