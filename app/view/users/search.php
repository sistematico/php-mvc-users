<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Search</li>
        </ol>
    </nav>

    <h1>Search</h1>
    <?php if (isset($users)) { ?>
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Role</th>
                    <?php if (DEBUG === true) { ?>
                    <th scope="col">Hash</th>
                    <?php } ?>
                    <th scope="col">Valid</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) { ?>
                <tr>
                    <th scope="row"><?php if (isset($user->id)) echo htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?></th>
                    <td><?php if (isset($user->user)) echo htmlspecialchars($user->user, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($user->email)) echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>                   
                        <?php if (isset($user->role) && $user->role === 'admin') { ?>
                            <span class="badge badge-danger"><?php echo htmlspecialchars($user->role, ENT_QUOTES, 'UTF-8'); ?></span>
                        <?php } else { ?>
                            <span class="badge badge-success">user</span>
                        <?php } ?>
                    </td>
                    <?php if (DEBUG === true) { ?>
                    <td><?php echo (isset($user->temp) ? $user->temp : 'SEM HASH'); ?></td>
                    <?php } ?>
                    <td><i class="fas fa-<?php echo ($user->valid == 1 ? 'check' : 'times'); ?>-circle"></i></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Action Buttons">
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                                <a class="btn btn-sm btn-secondary" onClick="javascript: return confirm('Are you sure you want to delete?');" href="<?php echo URL . 'users/delete/' . htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>"><i class="fas fa-trash"></i></a>
                                <a class="btn btn-sm btn-secondary" href="<?php echo URL . 'users/edit/' . htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-sm btn-secondary" href="<?php echo URL . 'users/reset/' . htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>"><i class="fas fa-undo"></i></a>
                            <?php } ?>
                            <a class="btn btn-sm btn-secondary" href="<?php echo URL . 'users/profile/' . htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>"><i class="fas fa-search"></i></a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No results.</p>
    <?php } ?>
</main>
