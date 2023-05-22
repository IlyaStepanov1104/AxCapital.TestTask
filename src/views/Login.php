<?php

namespace views;

use Page;

class Login extends Page
{
    private $SALT = "1305LoVe2009";

    public function middle(): void
    {
        echo '<div class="container mregister">
            <div id="login">
            <h1>ВХОД</h1>
            <div class="errors">';

        $this->errorOrLogIn();

        echo '</div>
            <form action="#" id="loginform" method="post" name="loginform">
                <p>
                    <label for="username">Имя пользователя<br>
                        <input class="input" id="username" name="username" size="32" type="text" value="">
                    </label>
                </p>
                <p>
                    <label for="password">Пароль<br>
                        <input class="input" id="password" name="password" size="32" type="password" value="">
                    </label>
                </p>
                <input type="hidden" name="send" value="1">
                <p class="submit"><input class="button" type= "submit" value="Войти"></p>
            </form>
        </div>
    </div>';
    }


    public function errorOrLogIn(): void
    {
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $sth = $this->pdo->prepare("SELECT * FROM admin WHERE username='" . $username . "'");
            $sth->execute();
            $find = $sth->fetch();
            if (password_verify($password . $this->SALT, $find['password'])) {
                $_SESSION['user'] = $find['username'];
                header("Location: /");
            } else {
                echo 'ОШИБКА: некорректные имя пользователя или пароль!';
            }
        } else if ($_POST['send'] == '1') {
            echo 'ОШИБКА: Все параметры обязательны!';
        }
    }
}