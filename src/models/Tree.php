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
                    'id' => $leaf['id'],
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
               function modal(text) {
                    let modal = document.getElementById('modal');
                    modal.innerHTML = '<h3>' + text + '</h3>';
                    modal.style.display = 'block';
               }
                modal('Описание \'" . $leaf['name'] . "\'  :  " . $leaf['description'] . "');
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
                echo "<p>" . str_repeat("&mdash;", $nesting_number) . $leaf['name'] . $this->editIcon($leaf['name'], $leaf['id']) . "</p>";
                if (!isset($data['children'])) {
                    $this->printDataAdmin($leaf['children'], $nesting_number + 1);
                }
            }
        }
    }

    public function printDataOptions($data, $nesting_number = 0, $current=null, $parent=null)
    {
        if (is_array($data)) {
            foreach ($data as $leaf) {
                if ($current == $leaf['name']){
                    break;
                }
                if ($parent == $leaf['name']){
                    echo '<option selected="selected" value="' . $leaf['name'] . '">' . str_repeat("&mdash;", $nesting_number) . $leaf['name'] . "</option>";
                } else{
                    echo '<option value="' . $leaf['name'] . '">' . str_repeat("&mdash;", $nesting_number) . $leaf['name'] . "</option>";
                }
                if (!isset($data['children'])) {
                    $this->printDataOptions($leaf['children'], $nesting_number + 1, $current);
                }
            }
        }
    }

    private function editIcon($name, $id) {
        return '<?xml version="1.0" encoding="utf-8"?>
        <svg name="'.$name.'" id="'.$id.'" onclick="window.location.replace(\'../admin-data-edit/?name=\' + document.getElementById('.$id.').getAttribute(\'name\') + \'\')" width="1.2em" height="1.2em" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M15.8787 3.70705C17.0503 2.53547 18.9498 2.53548 20.1213 3.70705L20.2929 3.87862C21.4645 5.05019 21.4645 6.94969 20.2929 8.12126L18.5556 9.85857L8.70713 19.7071C8.57897 19.8352 8.41839 19.9261 8.24256 19.9701L4.24256 20.9701C3.90178 21.0553 3.54129 20.9554 3.29291 20.7071C3.04453 20.4587 2.94468 20.0982 3.02988 19.7574L4.02988 15.7574C4.07384 15.5816 4.16476 15.421 4.29291 15.2928L14.1989 5.38685L15.8787 3.70705ZM18.7071 5.12126C18.3166 4.73074 17.6834 4.73074 17.2929 5.12126L16.3068 6.10738L17.8622 7.72357L18.8787 6.70705C19.2692 6.31653 19.2692 5.68336 18.8787 5.29283L18.7071 5.12126ZM16.4477 9.13804L14.8923 7.52185L5.90299 16.5112L5.37439 18.6256L7.48877 18.097L16.4477 9.13804Z" fill="#000000"/>
        </svg>';
    }

}