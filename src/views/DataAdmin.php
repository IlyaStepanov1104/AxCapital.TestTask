<?php

namespace views;
use models\Tree;
use Page;

class DataAdmin extends Page
{
    public Tree $tree;

    public function __construct($user, $pdo)
    {
        parent::__construct($user, $pdo);
        $this->tree = new Tree($pdo);
    }

    public function middle()
    {

        echo '<p><a href="/admin-data-add/">Добавить элемент</a></p>';
        echo '<p><a href="/admin-data-delete/">Удалить элемент</a></p>';
        echo '<p><a href="/admin-data-edit/">Редактировать элемент</a></p>';
        $this->tree->printDataAdmin($this->tree->data);
    }
}