<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
    </nav>

    <h1>Users</h1>
    <?php if (isset($result)) { ?>
        <div class="alert alert-primary" role="alert"><?php echo $result; ?></div>
    <?php } ?>

    <?php if (isset($users) && count($users) > 0) { ?>
    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Login</th>
                <th scope="col">E-mail</th>
                <th scope="col">Role</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <th scope="row"><?php if (isset($user->id)) echo htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?></th>
                    <td><?php if (isset($user->user)) echo htmlspecialchars($user->user, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($user->email)) echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                    <?php if (isset($user->role)) { ?>
                    <td>                   
                        <?php if ($user->role === 'admin') { ?>
                            <span class="badge badge-danger"><?php echo htmlspecialchars($user->role, ENT_QUOTES, 'UTF-8'); ?></span>
                        <?php } else { ?>
                            <span class="badge badge-success"><?php echo htmlspecialchars($user->role, ENT_QUOTES, 'UTF-8'); ?></span>
                        <?php } ?>
                    </td>
                    <?php } ?>
                    <td>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
                            <a onClick="javascript: return confirm('Are you sure you want to delete?');" href="<?php echo URL . 'users/delete/' . htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>"><i class="fas fa-trash"></i></a>
                            <a href="<?php echo URL . 'users/edit/' . htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>"><i class="fas fa-edit"></i></a>
                        <?php } ?>
                        <a href="<?php echo URL . 'users/profile/' . htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>"><i class="fas fa-search"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <p><small>Users: <?php echo $amount; ?></small></p>
    <!-- <h3>Amount of users (via AJAX)</h3>
    <div id="javascript-ajax-result-box" class="mb-3"></div>
    <div>
        <button id="javascript-ajax-button" class="btn btn-danger mb-2">Get Amount</button>
    </div> -->
    <?php } else { ?>
        <p>No results.</p>
    <?php } ?>
</main>
