<?php

class AllPosts {
    public function show($page = 0) {
        if ($page < 0) {
            echo 'invalid';
            return;
        }

        # Include the template for this Controller:
        include dirname(__FILE__).'/../views/all_posts.tmpl';
    }
}
