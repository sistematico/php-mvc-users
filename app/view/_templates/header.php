<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PHP MVC Users</title>
    <link rel="stylesheet" href="<?php echo URL; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo URL; ?>css/fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo URL; ?>css/main.css">
    <link rel="shortcut icon" href="<?php echo URL; ?>img/favicon.ico">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="<?php echo URL; ?>">
                <img src="<?php echo URL; ?>img/user.svg" width="30" height="30" alt="PHP MVC Users" style="margin-top: -5px;">
                PHP MVC Users
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL; ?>pages/about"><i class="fas fa-address-card"></i> About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL; ?>pages/credits"><i class="fas fa-file"></i> Credits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL; ?>users"><i class="fas fa-users"></i> Users</a>
                    </li>
                    <?php if (!isset($_SESSION['logged'])) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> Account
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?php echo URL; ?>users/login">Login</a>
                            <a class="dropdown-item" href="<?php echo URL; ?>users/signup">Signup</a>
                        </div>
                    </li>
                    <?php } else { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo (isset($user->avatar)) ? '<img src=' . URL . $user->avatar . ' />' : '<i class="fas fa-user-circle"></i>'; ?> <?php echo (isset($_SESSION['user'])) ? $_SESSION['user'] : 'Account'; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?php echo URL; ?>users/logout">Logout</a>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
                <form action="<?php echo URL; ?>users/search" method="post" class="form-inline my-2 my-lg-0">
                    <input name="term" class="form-control mr-sm-2" type="text" placeholder="Search a user" aria-label="Search">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </nav>
    </header>
