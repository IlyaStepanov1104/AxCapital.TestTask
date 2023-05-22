<?php

namespace views;

use Exception;
use Page;

class DataAdminAdd extends Page
{

    public function middle()
    {
        echo '<div class="container mregister">
            <div id="login">
            <h1>ДОБАВИТЬ ЭЛЕМЕНТ</h1>
            <div class="errors">';

        $this->errorOrAdd();

        echo '</div>
                    <form action="#" id="add" method="post" name="add">
                        <p>
                            <label for="name">Название<br>
                                <input class="input" id="name" name="name" size="32" type="text" value="">
                            </label>
                        </p>
                        <p>
                            <label for="description">Описание<br>
                                <input class="input" id="description" name="description" type="text" value="">
                            </label>
                        </p>
                        <p>
                            <label for="parent">Имя родителя<br>
                                <input class="input" id="parent" name="parent" size="32" type="text" value="">
                            </label>
                        </p>
                        <input type="hidden" name="send" value="3">
                        <p class="submit"><input class="button" type= "submit" value="Добавить"></p>
                    </form>
                </div>
            </div>';
    }

    public function errorOrAdd()
    {
        if(!empty($_POST['name'])) {
            $name = $_POST['name'];
            $description = $_POST['description'] ? "'".$_POST['description']."'" : 'NULL';
            $parent_name = $_POST['parent'] ? "'".$_POST['parent']."'" : 'NULL';

            $sth = $this->pdo->prepare("SELECT id FROM `data` WHERE `name` = ".$parent_name);
            $sth->execute();
            $parent = $sth->fetch();
            if ($parent == null){
                $parent = 'NULL';
            } else {
                $parent = $parent['id'];
            }
            $sth = $this->pdo->prepare("INSERT INTO data (id, name, description, parent) VALUES (NULL, '".$name."', ".$description.", ".$parent.")");
            try {
                $sth->execute();
            } catch (Exception $exception){
                echo 'Ошибка добавления!';
                return;
            }
            $find = $this->pdo->lastInsertId();
            if ($find == 0){
                echo 'Ошибка добавления!';
            } else {
                header('Location: /admin-data/');
            }
        } else if ($_POST['send'] == 3){
            echo 'ОШИБКА: параметр имя - обязателен!';
        }
    }
}