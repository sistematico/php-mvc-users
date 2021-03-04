<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2" style="--bs-breadcrumb-divider: '>';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    <h1>Users</h1>
    <h3>Edit a user</h3>

    <?php if (isset($result['message'])) { ?>
        <div class="alert alert-<?php echo $result['class'] ?? 'primary'; ?>" role="alert"><?php echo $result['message']; ?></div>
    <?php } ?>

    <form class="form-inline" action="<?php echo URL; ?>users/update" method="post">
        <div class="form-group mb-2 mr-2">        
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                <label for="role">Role</label>
                <select name="role" class="form-control" id="role">
                    <option value="admin" <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') echo 'selected'; ?>>admin</option>
                    <option value="user" <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'user') echo 'selected'; ?>>user</option>
                </select>
            <?php } else { ?>
                <input name="role" class="form-control" type="text" placeholder="<?php echo isset($user->role) ? htmlspecialchars($user->role, ENT_QUOTES, 'UTF-8') : ''; ?>" readonly>
            <?php } ?>
        </div>
        <div class="form-group mb-2 mr-2">
            <label for="login" class="sr-only">Login</label>
            <input name="login" type="text" class="form-control" id="login" placeholder="Login" value="<?php echo isset($_SESSION['role']) ? htmlspecialchars($user->user, ENT_QUOTES, 'UTF-8') : ''; ?>" required />
        </div>
        <div class="form-group mb-2 mr-2">
            <label for="email" class="sr-only">E-mail</label>
            <input name="email" type="text" class="form-control" id="email" placeholder="E-mail" value="<?php echo isset($_SESSION['role']) htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?>" required />
        </div>
        <div class="form-group mb-2 mr-2">
            <label for="password" class="sr-only">Password</label>
            <input name="password" type="text" class="form-control" id="password" placeholder="Password" />
        </div>

        <div class="form-group mb-2 mr-2">
            <label>
                <input name="valid" type="checkbox" value="sim" <?php echo (isset($user->valid) && $user->valid == 1) ? 'checked' : ''; ?>> Validado                
            </label>
        </div>
        
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>" />
        <button name="submit_update_user" type="submit" class="btn btn-primary mb-2">Update</button>
    </form>
</main>

