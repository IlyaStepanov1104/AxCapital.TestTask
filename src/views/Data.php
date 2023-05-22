<?php

namespace views;
use models\Tree;
use Page;

class Data extends Page
{
    public Tree $tree;

    public function __construct($user, $pdo)
    {
        parent::__construct($user, $pdo);
        $this->tree = new Tree($pdo);
    }

    public function middle()
    {
        $this->tree->printTree($this->tree->data);

        echo '<script>
            var coll = document.getElementsByClassName("collapsible");
            var i;
        
            for (i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var content = this.parentNode.nextSibling;
                    if (content.style.display === "block") {
                        content.style.display = "none";
                    } else {
                        content.style.display = "block";
                    }
                });
            }
        </script>';

    }
}