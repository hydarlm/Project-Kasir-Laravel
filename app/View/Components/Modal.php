<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $name;
    public $show;
    public $maxWidth;

    public function __construct($name, $show = false, $maxWidth = '2xl')
    {
        $this->name = $name;
        $this->show = $show;
        $this->maxWidth = $maxWidth;
    }

    public function render()
    {
        return view('components.modal');
    }
}
