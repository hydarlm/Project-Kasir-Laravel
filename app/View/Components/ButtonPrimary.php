<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ButtonPrimary extends Component
{
    public $type;
    public $disabled;

    public function __construct($type = 'button', $disabled = false)
    {
        $this->type = $type;
        $this->disabled = $disabled;
    }

    public function render()
    {
        return view('components.button-primary');
    }
}
