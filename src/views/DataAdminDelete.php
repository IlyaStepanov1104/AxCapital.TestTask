<?php

namespace views;

use Page;
use PDO;

class DataAdminDelete extends Page
{
    public function middle()
    {
        echo '<div class="container mregister">
            <div id="login">
            <h1>УДАЛИТЬ ЭЛЕМЕНТ</h1>
            <div class="errors">';

        $this->errorOrDelete();

        echo '</div>
                    <form action="#" id="delete" method="post" name="add">
                        <p>
                            <label for="name">Название<br>
                                <input class="input" id="name" name="name" size="32" type="text" value="">
                            </label>
                        </p>
                        <input type="hidden" name="send" value="4">
                        <p class="submit"><input class="button" type= "submit" value="Удалить"></p>
                    </form>
                </div>
            </div>';
    }

    public function errorOrDelete()
    {
        if(!empty($_POST['name'])) {
            $name = $_POST['name'];

            $sth = $this->pdo->prepare("SELECT * FROM `data` WHERE `name` = '".$name."'");
            $sth->execute();
            $id = $sth->fetch();
            if ($id == null){
                echo 'ОШИБКА: нет такого элемента!';
            } else {
                $id = $id['id'];
                $childs = array(['id' => $id]);
                do {
                    $id = array_shift($childs)['id'];
                    $sth = $this->pdo->prepare("DELETE FROM data WHERE data.id = ".$id);
                    $sth->execute();
                    $search = $this->pdo->prepare("SELECT id FROM data WHERE parent = ".$id);
                    $search->execute();
                    $childs = array_merge($childs, $search->fetchAll(PDO::FETCH_ASSOC));
                } while (count($childs) != false);
                header('Location: /admin-data/');
            }
        } else if ($_POST['send'] == 4){
            echo 'ОШИБКА: параметр имя - обязателен!';
        }
    }
}