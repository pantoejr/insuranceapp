<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SectionNavigation extends Component
{
    public $sections;
    public $model;
    public $users;
    public $policies;

    public function __construct($sections, $model, $users = null, $policies = null)
    {
        $this->sections = $sections;
        $this->model = $model;
        $this->users = $users;
        $this->policies = $policies;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.section-navigation');
    }
}
