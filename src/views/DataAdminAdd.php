<?php

namespace views;

use Exception;
use models\Tree;
use Page;

class DataAdminAdd extends Page
{
    public Tree $tree;

    public function __construct($user, $pdo)
    {
        parent::__construct($user, $pdo);
        $this->tree = new Tree($pdo);
    }
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
                                <select class="input" id="parent" name="parent" size="1">';
        echo '<option value="NULL"></option>';
        $this->tree->printDataOptions($this->tree->data);
        echo '                </select>
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

    /**
     * @param $nesting_number
     * @return void
     */
    public function options($nesting_number): void
    {
        foreach ($this->tree->data as $leaf) {
            echo '<option>' . str_repeat("&mdash;", $nesting_number) . $leaf['name'] . '</option>';
        }
    }
}