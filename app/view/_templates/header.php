<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
?>
<!doctype html>
<html lang="pt-br" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta property="og:title" content="PHP MVC Users" />
    <meta property="og:description" content="CRUD simple example" />
    <meta property="og:type" content="website" />",
    <meta property="og:url" content="<?php echo URL; ?>" />
    <meta property="og:image" content="<?php echo URL; ?>img/logo.png" />
    <title>PHP MVC Users</title>
    <link rel="stylesheet" href="<?php echo URL; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo URL; ?>css/hamburgers.min.css">
    <link rel="stylesheet" href="<?php echo URL; ?>css/fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo URL; ?>css/main.css">
    <link rel="shortcut icon" href="<?php echo URL; ?>img/favicon.ico">
</head>
<body class="d-flex flex-column h-100">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo URL; ?>">
                    <img src="<?php echo URL; ?>img/logo-32x32.png" width="30" height="30" alt="PHP MVC Users" style="margin-top: -5px;">
                    PHP MVC Users
                </a>

                <button class="navbar-toggler hamburger" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                    <ul class="navbar-nav me-auto">
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
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> Account
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo URL; ?>users/login"><i class="fas fa-user"></i> Login</a>
                                <a class="dropdown-item" href="<?php echo URL; ?>users/signup"><i class="fas fa-user-plus"></i> Signup</a>
                            </div>
                        </li>
                        <?php } else { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo (isset($user->avatar)) ? '<img src=' . URL . $user->avatar . ' />' : '<i class="fas fa-user-circle"></i>'; ?> <?php echo (isset($_SESSION['user'])) ? $_SESSION['user'] : 'Account'; ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo URL; ?>users/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                    <form action="<?php echo URL; ?>users/search" method="post" class="d-flex">
                        <input name="term" class="form-control me-1" type="text" placeholder="Search a user" aria-label="Search">
                        <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
