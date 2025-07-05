<?php
?>
<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputField extends Component
{
    public $type;
    public $name;
    public $id;
    public $value;
    public $placeholder;
    public $required;
    public $readonly;
    public $disabled;

    public function __construct($type = 'text', $name = '', $id = null, $value = '', $placeholder = '', $required = false, $readonly = false, $disabled = false)
    {
        $this->type = $type;
        $this->name = $name;
        $this->id = $id;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->readonly = $readonly;
        $this->disabled = $disabled;
    }

    public function render()
    {
        return view('components.input-field');
    }
}
