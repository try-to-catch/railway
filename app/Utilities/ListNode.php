<?php

namespace App\Utilities;

class ListNode {
    public $seat;
    public $next;

    public function __construct($seat, $next = null) {
        $this->seat = $seat;
        $this->next = $next;
    }
}
