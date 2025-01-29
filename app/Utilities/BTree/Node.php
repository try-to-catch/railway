<?php

namespace App\Utilities\BTree;

class Node {
    public $price;
    public $seat;
    public $left;
    public $right;

    public function __construct($price, $seat = null) {
        $this->price = $price;
        $this->seat = $seat;
        $this->left = null;
        $this->right = null;
    }
}
