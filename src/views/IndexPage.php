<?php

namespace views;

use Page;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

class IndexPage extends Page
{

    public $message;

    public function __construct($user, $pdo, $message)
    {
        parent::__construct($user, $pdo);
        $this->message = $message;
    }

    public function middle()
    {
        echo "<div class='welcome'>";
        if (isset($this->user)) {
            echo "<h2>Добро пожаловать, <span>" . $this->user . "</span>!</h2>";
        } else {
            echo "<h2>Добро пожаловать!</h2>";
        }
        if ($this->message != null) {
            echo '<h3 class="warning">' . $this->message . "</h3>";
        }
        echo "</div>";
    }
}