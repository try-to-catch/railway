<?php

namespace App\Utilities;

class ListNode
{
    public $data; // Данные узла (поезд, вагон или место)

    public $next; // Ссылка на следующий узел

    public function __construct($data, $next = null)
    {
        $this->data = $data;
        $this->next = $next;
    }
}
