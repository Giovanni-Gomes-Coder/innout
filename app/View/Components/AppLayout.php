<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\WorkingHours;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $workingHours = WorkingHours::loadFromUserAndDate(auth()->user()->id, date('Y-m-d'));
        $workedInterval = $workingHours->getWorkedInterval()->format('%H:%I:%S');
        $exitTime = $workingHours->getExitTime()->format('H:i:s');
        $activeClock = $workingHours->getActiveClock();
        return view('layouts.app',['workingHours' => $workingHours, 'workedInterval' => $workedInterval,'exitTime' => $exitTime, 'activeClock' => $activeClock]);
    }
}
