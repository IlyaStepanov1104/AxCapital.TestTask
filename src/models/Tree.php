<?php

namespace models;

use PDO;

class Tree
{

    public array $data;

    public function __construct($pdo)
    {
        $sth = $pdo->prepare("SELECT * FROM data");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        $this->data = $this->createTree($data);
    }

    public function createTree(&$data, $parent_id = null): array
    {
        $tree = array();
        foreach ($data as &$leaf) {
            if ($leaf['parent'] == $parent_id) {
                $children = $this->createTree($data, $leaf['id']);
                if ($children) {
                    $leaf['children'] = $children;
                }
                $tree[] = array(
                    'name' => $leaf['name'],
                    'description' => $leaf['description'],
                    'children' => $leaf['children']
                );
            }
        }
        return $tree;
    }


    public function printTree($tree)
    {
        if (is_array($tree)) {
            foreach ($tree as $leaf) {
                echo "<div class='flex'><p onclick=\"
                alert('Описание \'" . $leaf['name'] . "\':  " . $leaf['description'] . "');
            \">" . $leaf['name'] . "</p>
            <button class='collapsible'>+</button></div>";
                if (!isset($tree['children'])) {
                    print_r($tree['children']);
                    echo "<div class='content'>";
                    $this->printTree($leaf['children']);
                    echo '</div>';
                }
            }
        }
    }

    public function printDataAdmin($data, $nesting_number = 0)
    {
        if (is_array($data)) {
            foreach ($data as $leaf) {
                echo "<p>" . str_repeat("&mdash;", $nesting_number) . $leaf['name'] . "</p>";
                if (!isset($data['children'])) {
                    $this->printDataAdmin($leaf['children'], $nesting_number + 1);
                }
            }
        }
    }

}