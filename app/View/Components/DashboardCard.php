<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct($title, $icon, $color)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard-card');
    }
}
