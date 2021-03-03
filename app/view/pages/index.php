<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Home</li>
        </ol>
    </nav>

    <h1>Index</h1>
    <p class="lead">Welcome...</p>
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
                
            </div>
        </div>

    </div>
</div>
