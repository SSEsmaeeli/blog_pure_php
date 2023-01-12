<?php require('layouts/header.view.php'); ?>

    <h1>Welcome</h1>

    <?php if (isAuth()) { ?> <br>
    name: <?= authUser()?->name ?> <br>
    Family: <?= authUser()?->family ?> <br>
    Username: <?= authUser()?->username ?> <br>
    Registered At: <?= authUser()?->created_at ?> <br>
    <?php } ?>
<?php require('layouts/footer.view.php'); ?>