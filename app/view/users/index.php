<main role="main" class="container">

    <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
    </nav>

    <h1>Users</h1>
    <h3>Users: <?php echo $amount; ?></h3>
    <h3>Amount of users (via AJAX)</h3>
    <div id="javascript-ajax-result-box" class="mb-3"></div>
    <div>
        <button id="javascript-ajax-button" class="btn btn-danger mb-2">Get Amount</button>
    </div>

    <h3>List of users (data from model)</h3>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">E-mail</th>
                <th scope="col">Password</th>
                <th scope="col">Delete</th>
                <th scope="col">Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
            <tr>
                <th scope="row"><?php if (isset($user->id)) echo htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?></th>
                <td><?php if (isset($user->email)) echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php if (isset($user->password)) echo htmlspecialchars($user->password, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><a onClick="javascript: return confirm('Are you sure you want to delete?');" href="<?php echo URL . 'users/deleteuser/' . htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>">delete</a></td>
                <td><a href="<?php echo URL . 'users/edituser/' . htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>">edit</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</main>
