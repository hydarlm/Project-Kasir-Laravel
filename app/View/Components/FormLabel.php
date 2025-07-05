<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormLabel extends Component
{
    public $for;
    public $required;

    public function __construct($for, $required = false)
    {
        $this->for = $for;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.form-label');
    }
}
