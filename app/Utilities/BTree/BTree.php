<?php

namespace App\Utilities\BTree;

class BTree
{
    private $root;
    private $t;      // Minimum degree

    public function __construct($t)
    {
        $this->t = $t;
        $this->root = new BTreeNode($t);
    }

    public function insert($key, $value): void
    {
        $root = $this->root;

        if ($root->isFull()) {
            $newRoot = new BTreeNode($this->t);
            $newRoot->leaf = false;
            $newRoot->children[0] = $root;
            $this->splitChild($newRoot, 0);
            $this->root = $newRoot;
            $this->insertNonFull($newRoot, $key, $value);
        } else {
            $this->insertNonFull($root, $key, $value);
        }
    }

    private function splitChild($parent, $index): void
    {
        $t = $this->t;
        $child = $parent->children[$index];
        $newNode = new BTreeNode($t);
        $newNode->leaf = $child->leaf;

        // Move the last (t-1) keys of child to newNode
        for ($i = 0; $i < $t - 1; $i++) {
            $newNode->keys[$i] = $child->keys[$i + $t];
            $newNode->values[$i] = $child->values[$i + $t];
            unset($child->keys[$i + $t]);
            unset($child->values[$i + $t]);
        }

        // If not leaf, move the last t children of child to newNode
        if (!$child->leaf) {
            for ($i = 0; $i < $t; $i++) {
                $newNode->children[$i] = $child->children[$i + $t];
                unset($child->children[$i + $t]);
            }
        }

        // Insert new child into parent
        for ($i = count($parent->keys); $i >= $index + 1; $i--) {
            $parent->children[$i + 1] = $parent->children[$i];
        }
        $parent->children[$index + 1] = $newNode;

        // Move middle key to parent
        for ($i = count($parent->keys) - 1; $i >= $index; $i--) {
            $parent->keys[$i + 1] = $parent->keys[$i];
            $parent->values[$i + 1] = $parent->values[$i];
        }
        $parent->keys[$index] = $child->keys[$t - 1];
        $parent->values[$index] = $child->values[$t - 1];
        unset($child->keys[$t - 1]);
        unset($child->values[$t - 1]);
    }

    private function insertNonFull($node, $key, $value): void
    {
        $i = count($node->keys) - 1;

        if ($node->leaf) {
            while ($i >= 0 && $key < $node->keys[$i]) {
                $node->keys[$i + 1] = $node->keys[$i];
                $node->values[$i + 1] = $node->values[$i];
                $i--;
            }
            $node->keys[$i + 1] = $key;
            $node->values[$i + 1] = $value;
        } else {
            while ($i >= 0 && $key < $node->keys[$i]) {
                $i--;
            }
            $i++;

            if ($node->children[$i]->isFull()) {
                $this->splitChild($node, $i);
                if ($key > $node->keys[$i]) {
                    $i++;
                }
            }
            $this->insertNonFull($node->children[$i], $key, $value);
        }
    }

    public function search($key)
    {
        return $this->searchNode($this->root, $key);
    }

    private function searchNode($node, $key)
    {
        $i = 0;
        while ($i < count($node->keys) && $key > $node->keys[$i]) {
            $i++;
        }

        if ($i < count($node->keys) && $key == $node->keys[$i]) {
            return $node->values[$i];
        }

        if ($node->leaf) {
            return null;
        }

        return $this->searchNode($node->children[$i], $key);
    }

    public function searchRange($min, $max): array
    {
        $result = [];
        $this->searchRangeNode($this->root, $min, $max, $result);
        return $result;
    }

    private function searchRangeNode($node, $min, $max, &$result): void
    {
        $i = 0;

        while ($i < count($node->keys) && $node->keys[$i] < $min) {
            $i++;
        }

        if (!$node->leaf) {
            $this->searchRangeNode($node->children[$i], $min, $max, $result);
        }

        while ($i < count($node->keys) && $node->keys[$i] <= $max) {
            $result[] = $node->values[$i];
            if (!$node->leaf && $i + 1 < count($node->children)) {
                $this->searchRangeNode($node->children[$i + 1], $min, $max, $result);
            }
            $i++;
        }
    }
}
