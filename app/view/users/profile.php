<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
    </nav>

    <h1>Profile</h1>
    <?php if (isset($result['message'])) { ?>
        <div class="alert alert-primary" role="alert"><?php echo $result['message']; ?></div>
    <?php } ?>

    <?php if (isset($user)) { ?>
        <div class="card">
            <div class="card-header"><?php if (isset($user->role)) { echo $user->role; } ?></div>
            <div class="card-body">
                <h5 class="card-title">
                    <?php if (isset($user->avatar)) { ?>
                        <img src="<?php if (isset($user->avatar)) { echo $user->avatar; } ?>" class="img-fluid rounded-circle float-left mr-4" alt="<?php if (isset($user->user)) { echo $user->user; } ?>" style="width: 100px; height: 100px"> <?php if (isset($user->user)) { echo $user->user; } ?>
                    <?php } else { ?>
                        <img src="<?php echo URL; ?>img/avatar/default.png" class="img-fluid rounded-circle float-left mr-4" alt="<?php if (isset($user->user)) { echo $user->user; } ?>" style="width: 100px; height: 100px"> <?php if (isset($user->user)) { echo $user->user; } ?>
                    <?php } ?>
                </h5>
                <p class="card-text"><?php if (isset($user->bio)) { echo $user->bio; } ?></p>
            </div>
            <div class="card-footer">
                <small class="text-muted">
                    <a href="mailto:<?php if (isset($user->email)) { echo $user->email; } ?>">
                        <span style="font-size: 2em;"><i class="fas fa-envelope"></i></span>
                    </a>
                </small>
            </div>
        </div>
    <?php } else { ?>
        <p>No results.</p>
    <?php } ?>
</main>
