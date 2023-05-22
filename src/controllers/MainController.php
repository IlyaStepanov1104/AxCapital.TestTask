<?php

namespace controllers;

use views\{Data, DataAdmin, DataAdminAdd, DataAdminDelete, DataAdminEdit, Error404, IndexPage, Login, LogOut, Register};
use models\Tree;
use PDO;
use PDOException;

class MainController
{
    public $user;
    public $pdo;

    private $DB_SERVER = "localhost";
    private $DB_USER = "root";
    private $DB_PASS = "root";
    private $DB_NAME = "AxCapital";

    public function __construct($user)
    {
        $this->user = $user;
        try {
            $this->pdo = new PDO('mysql:dbname=' . $this->DB_NAME . ';host=' . $this->DB_SERVER . '', $this->DB_USER, $this->DB_PASS);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function index($message = null)
    {
        (new IndexPage($this->user, $this->pdo, $message))->view();
    }

    public function login()
    {
        if (isset($this->user)) {
            $this->index("Вы не можете войти в систему, потому что вы уже вошли в нее!");
            return;
        }
        (new Login($this->user, $this->pdo))->view();
    }

    public function error()
    {
        (new Error404($this->user, $this->pdo))->view();
    }

    public function register()
    {
        if (!isset($this->user)) {
            $this->index("У вас нет доступа к этой странице!");
            return;
        }
        (new Register($this->user, $this->pdo))->view();
    }

    public function logout()
    {
        if (!isset($this->user)) {
            $this->index("Вы не можете выйти из системы, потому что вы уже вышли из нее!");
            return;
        }
        (new LogOut($this->user, $this->pdo))->view();
    }

    public function data()
    {
        (new Data($this->user, $this->pdo))->view();
    }

    public function dataAdmin()
    {
        if (!isset($this->user)) {
            $this->index("У вас нет доступа к этой странице!");
            return;
        }
        (new DataAdmin($this->user, $this->pdo))->view();
    }

    public function dataAdminAdd()
    {
        if (!isset($this->user)) {
            $this->index("У вас нет доступа к этой странице!");
            return;
        }
        (new DataAdminAdd($this->user, $this->pdo))->view();
    }

    public function dataAdminDelete()
    {
        if (!isset($this->user)) {
            $this->index("У вас нет доступа к этой странице!");
            return;
        }
        (new DataAdminDelete($this->user, $this->pdo))->view();
    }

    public function dataAdminEdit()
    {
        if (!isset($this->user)) {
            $this->index("У вас нет доступа к этой странице!");
            return;
        }
        (new DataAdminEdit($this->user, $this->pdo))->view();
    }
}