<?php

namespace views;

use Page;

class DataAdminEdit extends Page
{
    public function middle()
    {
        echo '<div class="container mregister">
                <div id="login">
                <h1>РЕДАКТИРОВАТЬ ЭЛЕМЕНТ</h1>
                <form action="#" id="edit" method="post" name="edit">
                <div class="errors">';

        $find = $this->errorOrEdit();
        if (!$find){
            echo '<p>
                            <label for="name">Название редактируемого элемента<br>
                                <input class="input" id="name" name="name" size="32" type="text" value="">
                            </label>
                        </p>
                        </div>
                        <input type="hidden" name="send" value="5">
                        <p class="submit"><input class="button" type="submit" value="Выбрать"></p>
                    </form>
                </div>
            </div>';
        }

    }

    public function errorOrEdit(): bool
    {
        if ($_POST['send'] != 5){
            return false;
        } else if (empty($_POST['name'])){
            echo 'ОШИБКА: не найден данный элемент!';
            return false;
        } else if(empty($_POST['id'])) {
            $name = "'".$_POST['name']."'";
            $sth = $this->pdo->prepare("SELECT * FROM `data` WHERE `name` = ".$name);
            $sth->execute();
            $find = $sth->fetch();
            if ($find == null){
                echo 'ОШИБКА: не найден данный элемент!';
            } else {
                $sth = $this->pdo->prepare("SELECT name FROM `data` WHERE `id` = ".$find['parent']);
                $sth->execute();
                $parent = $sth->fetch();
                if ($parent == null){
                    $parent = 'NULL';
                } else {
                    $parent = $parent['name'];
                }
                $this->found($find, $parent);
                return true;
            }
        } else {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'] ? "'".$_POST['description']."'" : 'NULL';
            $parent_name = $_POST['parent'] ? "'".$_POST['parent']."'" : 'NULL';

            $sth = $this->pdo->prepare("SELECT id FROM `data` WHERE `name` = ".$parent_name);
            $sth->execute();
            $parent_id = $sth->fetch();
            if ($parent_id == null){
                $parent_id = 'NULL';
            } else {
                $parent_id = $parent_id['id'];
            }
            $sth = $this->pdo->prepare("UPDATE `data` SET `name` = '".$name."', `description` = ".$description.", `parent` = ".$parent_id." WHERE `data`.`id` = ".$id);
            $sth->execute();
            $find = $this->pdo->lastInsertId();
            print_r($sth);
            if ($find == 0) {
                header('Location: /admin-data/');
            } else {
                echo 'Ошибка редактирования!';
            }
        }
        return true;
    }


    public function found($find, string $parent): void
    {
        echo '
                            <input type="hidden" name="id" id="id" value="' . $find['id'] . '">
                            <p>
                                <label for="name">Название редактируемого элемента<br>
                                    <input class="input" id="name" name="name" size="32" type="text" value="' . $find['name'] . '">
                                </label>
                            </p>
                            <p>
                                <label for="name">Описание редактируемого элемента<br>
                                    <input class="input" id="description" name="description" size="32" type="text" value="' . $find['description'] . '">
                                </label>
                            </p>
                            <p>
                                <label for="name">Родитель редактируемого элемента<br>
                                    <input class="input" id="parent" name="parent" size="32" type="text" value="' . $parent . '">
                                </label>
                            </p>
                            </div>
                            <input type="hidden" name="send" value="5">
                            <p class="submit"><input class="button" type="submit" value="Сохранить"></p>';
    }
}