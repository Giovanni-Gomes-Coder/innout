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

    public function point() {
        $date = (new DateTime())->getTimestamp();
        $today = strftime('%d de %B de %Y', $date);
        $workingHours = WorkingHours::loadFromUserAndDate(auth()->user()->id, date('Y-m-d'));
        try{
            $currentTime = strftime('%H:%M:%S', time());
            $workingHours->innout($currentTime);
            addSuccessMsg('Ponto inserido com sucesso!');
        } catch(AppException $e) {
            addErrorMsg($e->getMessage());
        }
    }
}
