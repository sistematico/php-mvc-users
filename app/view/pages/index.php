<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Home</li>
        </ol>
    </nav>

    <h1>Index</h1>
    <p class="lead">Welcome...</p>
</main>

<div aria-live="polite" aria-atomic="true" class="bg-dark position-relative bd-example-toasts">
    <div class="toast-container position-absolute p-3 bottom-0 end-0">
        <div class="toast">
            <div class="toast-header">
                <img src="" class="rounded me-2" alt="...">
                <strong class="me-auto">Bootstrap</strong>
                <small>11 mins ago</small>
            </div>
            <div class="toast-body">
                <?php echo isset($result->message) ? $result->message : ''; ?>
            </div>
        </div>
    </div>
</div>

<script>
    let result = "<?php echo isset($result) ? $result : ''; ?>";
</script>