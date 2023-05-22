<?php

namespace views;

use Page;

class LogOut extends Page
{
    public function middle()
    {
        unset($_SESSION['user']);
        header("Location: /");
    }

}