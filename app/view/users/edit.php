<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>users">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    <h1>Users</h1>
    <h3>Edit a user</h3>
    <form class="form-inline" action="<?php echo URL; ?>users/update" method="post">
        <div class="form-group mb-2 mr-2">
            <label for="login" class="sr-only">Login</label>
            <input name="login" type="text" class="form-control" id="login" placeholder="Login" value="<?php echo htmlspecialchars($user->user, ENT_QUOTES, 'UTF-8'); ?>" required />
        </div>
        <div class="form-group mb-2 mr-2">
            <label for="email" class="sr-only">E-mail</label>
            <input name="email" type="text" class="form-control" id="email" placeholder="E-mail" value="<?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?>" required />
        </div>
        <div class="form-group mb-2 mr-2">
            <label for="password" class="sr-only">Password</label>
            <input name="password" type="text" class="form-control" id="password" placeholder="Password" value="<?php echo htmlspecialchars($user->password, ENT_QUOTES, 'UTF-8'); ?>" required />
        </div>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>" />
        <button name="submit_update_user" type="submit" class="btn btn-primary mb-2">Update</button>
    </form>
</main>
