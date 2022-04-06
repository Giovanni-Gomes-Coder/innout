<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WorkingHours;
use App\Models\User;
use App\Exception\AppException;
use DateTime;


define('DAILY_TIME', 60 * 60 * 8);
class Data_Generator extends Controller
{
    function getDayTemplateByOdds($regularRate, $extraRate, $lazyRate) {
        $regularDayTemplate = [
            'time1' => '08:00:00',
            'time2' => '12:00:00',
            'time3' => '13:00:00',
            'time4' => '17:00:00',
            'worked_time' => DAILY_TIME
        ];
        
        $extraHourDayTemplate = [
            'time1' => '08:00:00',
            'time2' => '12:00:00',
            'time3' => '13:00:00',
            'time4' => '18:00:00',
            'worked_time' => DAILY_TIME + 3600
        ];
        
        $lazyDayTemplate = [
            'time1' => '08:30:00',
            'time2' => '12:00:00',
            'time3' => '13:00:00',
            'time4' => '17:00:00',
            'worked_time' => DAILY_TIME - 1800
        ];
        
        $value = rand(0, 100);
        if($value <= $regularRate) {
            return $regularDayTemplate;
        } elseif($value <= $regularRate + $extraRate) {
            return $extraHourDayTemplate;
        } else {
            return $lazyDayTemplate;
        }
    }

    function populateWorkingHours($userId, $initialDate, $regularRate, $extraRate, $lazyRate) {
        $currentDate = $initialDate;
        $yesterday = new DateTime();
        $yesterday->modify('-1 day');
        $columns = ['user_id' => $userId, 'work_date' => $currentDate];
    
        while(isBefore($currentDate, $yesterday)) {
            if(!isWeekend($currentDate)) {
                $template = Data_Generator::getDayTemplateByOdds($regularRate, $extraRate, $lazyRate);
                $columns = array_merge($columns, $template);
                $workingHours = new WorkingHours($columns);
                $workingHours->save();
            }
            $currentDate = getNextDay($currentDate)->format('Y-m-d');
            $columns['work_date'] = $currentDate;
        }
    }

    function dataGenerator() {
        DB::delete('DELETE FROM working_hours');
        DB::delete('DELETE FROM users WHERE id > 5');

        $lastMonth = strtotime('first day of last month');
        Data_Generator::populateWorkingHours(1, date('Y-m-1'), 70, 20, 10);
        Data_Generator::populateWorkingHours(3, date('Y-m-d', $lastMonth), 20, 75, 5);
        Data_Generator::populateWorkingHours(4, date('Y-m-d', $lastMonth), 20, 10, 70);

        echo 'Tudo certo :)';
    }

    function point() {
        $workingHours = WorkingHours::loadFromUserAndDate(auth()->user()->id, date('Y-m-d'));
        print_r($workingHours);
        // try{
        //     $currentTime = strftime('%H:%M:%S', time());
        //     $workingHours->innout($currentTime);
        //     addSuccessMsg('Ponto inserido com sucesso!');
        // } catch(AppException $e) {
        //     addErrorMsg($e->getMessage());
        // }
        // echo route('dashboard', ['working_hours' => $workingHours] + $_SESSION['message']);
    }

    function forcedPoint(Request $request) {
        $workingHours = WorkingHours::loadFromUserAndDate(auth()->user()->id, date('Y-m-d'));
        try{
            $currentTime = strftime('%H:%M:%S', time());
            if (isset($request)) {
                $currentTime = $request;
            }        
            $workingHours->innout($currentTime);
            addSuccessMsg('Ponto inserido com sucesso!');
        } catch(AppException $e) {
            addErrorMsg($e->getMessage());
        }
    }
}
