<?php require('layouts/header.view.php'); ?>

    <h1>Login Page</h1>

    <form action="/login" method="post">
        Username: <input type="text" name="username"><br><br>
        Password: <input type="password" name="password"><br><br>
        <button>Login</button>
    </form>

<?php require('layouts/footer.view.php'); ?>