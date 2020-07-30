<footer class="footer">
    <div class="container">
        <span class="text-muted">
            Made with <i class="fas fa-heart"></i> by <a href="https://lucasbrum.net" target="_blank">Lucas</a> in Terenos.
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
<script src="<?php echo URL; ?>js/jquery.min.js"></script>
<script src="<?php echo URL; ?>js/bootstrap.bundle.min.js"></script>
<script>var url = "<?php echo URL; ?>";</script>
<script src="<?php echo URL; ?>js/app.js"></script>
</body>
</html>