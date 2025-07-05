<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DataTable extends Component
{
    public $headers;

    public function __construct($headers = [])
    {
        $this->headers = $headers;
    }

    public function render()
    {
        return view('components.data-table');
    }
}
