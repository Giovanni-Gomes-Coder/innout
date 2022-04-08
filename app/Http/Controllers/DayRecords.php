<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Exceptions\AppException;
use App\Models\WorkingHours;
use App\Models\User;
use DateTime;

class DayRecords extends Controller
{
    public function index(){
        $date = (new DateTime())->getTimestamp();
        $today = strftime('%d de %B de %Y', $date);
        $workingHours = WorkingHours::loadFromUserAndDate(auth()->user()->id, date('Y-m-d'));
        return view('day_records', ['today' => $today, 'workingHours' => $workingHours]);
    }

    function point() {
        $workingHours = WorkingHours::loadFromUserAndDate(auth()->user()->id, date('Y-m-d'));
        try{
            $currentTime = strftime('%H:%M:%S', time());
            $forcedTime = request('forcedTime');
            if($forcedTime){
                $currentTime = $forcedTime;
            }
            $workingHours->innout($currentTime);
            $type = 'success';
            $msg = 'Ponto inserido com sucesso!';
        } catch(AppException $e) {
            $type = 'danger';
            $msg = $e->getMessage();
        }
        return to_route('dashboard', ['workingHours' => $workingHours])->with($type, $msg);
    }


}
