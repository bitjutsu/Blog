<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
        <meta name="viewport" content="width=device-width">

        <title>HELLO THIS IS BLOG</title>

        <link rel="stylesheet" href="/assets/style.css">
        <link rel="shortcut icon" href="/assets/images/favicon.ico">
    </head>
    <body>
        <header>
            <a href="/">
                <img src="/assets/images/face.jpg" id="face">
                <div id="title">
                    <h1>HELLO THIS IS BLOG</h1>
                </div>
            </a>
        </header>

        <main>
            <?php
                # Start Router:
                include 'Router.php';
            ?>
        </main>

        <footer>
            Powered by a seemingly endless supply of <span class="icon-coffee"></span>
        </footer>
    </body>
</html>
