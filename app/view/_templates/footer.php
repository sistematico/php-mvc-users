<footer class="footer">
    <div class="container">
        <span class="text-muted">
            Made with <i class="fas fa-heart"></i> by <a href="https://lucasbrum.net" target="_blank">Lucas</a> in <a href="https://pt.wikipedia.org/wiki/Terenos" target="_blank">Terenos</a>.
            <div class="d-none d-sm-inline">Sources on <a href="https://github.com/sistematico/php-mvc-users" target="_blank">Github</a>.
            Proudly hosted by <a href="https://www.owned-networks.net/client_area/aff.php?aff=11" target="_blank">Owned-Networks</a>.
            <?php
                $time = microtime();
                $time = explode(' ', $time);
                $time = $time[1] + $time[0];
                $finish = $time;
                $total_time = round(($finish - $start), 4);
                echo 'Page generated in '.$total_time.' seconds.';
            ?>
            </div> 
        </span>
    </div>
</footer>

<?php

if (isset($_SESSION['last_message'])) {
    $toast['message'] = $_SESSION['last_message'];
    $toast['class'] = $_SESSION['last_class'];
}

if (isset($toast)) {
    ?>
<!--    <div aria-live="polite" aria-atomic="true" class="position-relative bottom-0 end-0">-->
        <div class="toast-container position-absolute p-3 bottom-0 end-0">
            <div class="toast align-items-center border-0 <?php echo $toast['class'] ?? 'text-white bg-dark'; ?>" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $toast['message']; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
<!--    </div>-->
    <?php
    unset($_SESSION['last_message'], $_SESSION['last_class']);
}
?>
<script src="<?php echo URL; ?>js/bootstrap.bundle.min.js"></script>
<script>var url = "<?php echo URL; ?>";</script>
<script src="<?php echo URL; ?>js/app.js?v=<?php echo uniqid(); ?>"></script>
</body>
</html>