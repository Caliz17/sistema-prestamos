<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class DashboardLayout extends Component
{
    public $section;

    public function __construct($section = '- Dashboard')
    {
        $this->section = $section;
    }

    public function render(): View
    {
        return view('components.dashboard-layout');
    }
}
