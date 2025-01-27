<?php

namespace App\Utilities;

class LinkedList
{
    private $head; // Начало списка

    public function __construct()
    {
        $this->head = null;
    }

    public function add($data)
    {
        $node = new ListNode($data);
        if ($this->head === null) {
            $this->head = $node;
        } else {
            $current = $this->head;
            while ($current->next !== null) {
                $current = $current->next;
            }
            $current->next = $node;
        }
    }

    public function getHead()
    {
        return $this->head;
    }
}
