<?php

$uri = $_SERVER['REQUEST_URI'];

if (preg_match('/^\/(?:\?p=(\d+)\/?)?$/', $uri, $matches)) {
    require 'controllers/AllPosts.php';

    $page = 0;
    if (count($matches) > 1) {
        $page = $matches[1];
    }

    AllPosts::show($page);
} elseif (preg_match('/^\/posts\/(\d+)\/?$/', $uri, $matches)) {
    require 'controllers/SinglePost.php';

    $id = $matches[1];

    SinglePost::show($id);
} else {
    echo 'not found!';
}
