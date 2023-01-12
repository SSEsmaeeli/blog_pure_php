<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HomePage</title>
    <style>
        header label{
            font-size: 2em;
            padding-left: 1em;
        }
        nav {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }
        nav ul li{
            display: inline;
            margin-left: 1em;
        }
        .float-right {
            float: right;
        }
        .mr-2 {
            margin-right: 2em;
        }
    </style>
</head>
<body>

    <header>
        <img src="https://via.placeholder.com/150">
        <label>Blog Post</label>
    </header>

    <nav>
        <ul>
            <li><a href="/">Overview</a></li>
            <?php if(isAuth()) { ?>
            <li><a href="posts/create">New Post</li>
            <?php } ?>
            <li><a href="#">Authors</a></li>

            <?php
                if(isAuth()) {
            ?>
                    <li class="float-right mr-2"><a href="/login">Logout</a></li>
            <?php
                }else{
            ?>
                    <li class="float-right mr-2"><a href="/login">Login</a></li>
            <?php
                }
            ?>

        </ul>
    </nav>