<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddItemModal extends Component
{
    public $title;
    public $id;
    public $route;
    public $field;

    public function __construct($title, $id, $route, $field)
    {
        $this->title = $title;
        $this->id = $id;
        $this->route = $route;
        $this->field = $field;
    }

    public function render()
    {
        return view('components.add-item-modal');
    }
} 