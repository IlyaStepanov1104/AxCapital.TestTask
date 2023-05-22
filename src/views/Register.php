<?php

namespace views;

use Page;
use PDOException;

class Register extends Page
{
    private $SALT = "1305LoVe2009";

    public function middle()
    {
        echo '<div class="container mregister">
            <div id="login">
            <h1>РЕГИСТРАЦИЯ</h1>
            <div class="errors">';

        $this->errorOrRegister();

        echo '</div>
                <form action="#" id="registerform" method="post" name="registerform">
                    <p>
                        <label for="username">Имя пользователя<br>
                            <input class="input" id="username_register" name="username_register" size="32" type="text" value="">
                        </label>
                    </p>
                    <p>
                        <label for="password">Пароль<br>
                            <input class="input" id="password_register" name="password_register" size="32" type="password" value="">
                        </label>
                    </p>
                    <input type="hidden" name="send" value="2">
                    <p class="submit"><input class="button" type= "submit" value="Войти"></p>
                </form>
            </div>
            </div>';
    }

    private function errorOrRegister()
    {
        if (!empty($_POST['username_register']) && !empty($_POST['password_register'])) {
            $username = $_POST['username_register'];
            $password = password_hash($_POST['password_register'] . $this->SALT, PASSWORD_BCRYPT);
            $sth = $this->pdo->prepare("INSERT INTO admin (id, username, password) VALUES (NULL, '" . $username . "', '" . $password . "')");
            try {
                $sth->execute();
            } catch (PDOException $exception) {
                echo 'ОШИБКА: ошибка регистрации!';
                return;
            }
            $find = $this->pdo->lastInsertId();
            if ($find == 0) {
                echo 'ОШИБКА: некорректные имя пользователя или пароль!';
            } else {
                $_SESSION['user'] = $_POST['username_register'];
                header("Location: /");
            }
        } else if ($_POST['send'] == '2') {
            echo 'ОШИБКА: Все параметры обязательны!';
        }
    }
}