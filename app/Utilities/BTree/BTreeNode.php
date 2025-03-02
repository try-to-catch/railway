<?php

namespace App\Utilities\BTree;

class BTreeNode
{
    public $keys = [];        // Array of keys (prices)

    public $values = [];      // Array of values (seat data)

    public $children = [];    // Array of child nodes

    public $leaf = true;     // Is this a leaf node?

    public $t;               // Minimum degree (determines minimum/maximum keys)

    public function __construct($t)
    {
        $this->t = $t;
    }

    public function isFull()
    {
        return count($this->keys) === 2 * $this->t - 1;
    }
}
