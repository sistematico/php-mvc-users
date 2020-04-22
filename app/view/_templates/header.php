<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PHP MVC Users</title>
    <link rel="stylesheet" href="<?php echo URL; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo URL; ?>css/fontawesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="<?php echo URL; ?>css/main.css">
    <link rel="shortcut icon" href="<?php echo URL; ?>img/favicon.ico">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="<?php echo URL; ?>">PHP MVC Users</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo URL; ?>">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL; ?>pages/credits">Credits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL; ?>pages/help">Help</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL; ?>users">Users</a>
                    </li>
                </ul>

                <form action="<?php echo URL; ?>users/search" method="post" class="form-inline my-2 my-lg-0">
                    <input name="term" class="form-control mr-sm-2" type="text" placeholder="Search a user" aria-label="Search">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                </form>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Account
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <?php if (!isset($_SESSION['logged'])) { ?>
                                <a class="dropdown-item" href="<?php echo URL; ?>users/login">Login</a>
                                <a class="dropdown-item" href="<?php echo URL; ?>users/signup">Signup</a>
                            <?php } else { ?>
                                <a class="dropdown-item" href="<?php echo URL; ?>users/logout">Logout</a>
                            <?php } ?>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>