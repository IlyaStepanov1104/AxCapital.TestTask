<?php

namespace views;

use Page;

class Error404 extends Page
{
    public function middle()
    {
        echo '<div class="welcome">';
        echo '<h2>ERROR 404!</h2>';
        echo '</div>';
    }
}