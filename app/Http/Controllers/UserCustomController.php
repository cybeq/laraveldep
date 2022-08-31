<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserCustomController extends Controller
{
    public function __construct(){
        $this->middleware('verified');
    }
    public function getUserDataById($id){
        $data = DB::table('users')
            ->select('nick', 'name', 'loc','avatar')
            ->where('id', $id)
            ->get();
        $data = json_decode(json_encode($data), true);
        return $data;
    }

    public function setOnline(bool $bool){
        switch ($bool){
            case true:
                    DB::table('users')->
                        where('id', Auth::user()->id)
                        ->update(['online'=>Carbon::now()->toDateTimeString()]);
                break;

            case false:

                break;
        }
    }

    public function lastTimeOnline($id){
        $data = DB::table('users')
            ->select('online')
            ->where('id', $id)
            ->get()->toArray();

        $startTime = Carbon::parse($data[0]->online);

        $endTime = Carbon::parse(Carbon::now()->toDateTimeString());

        Carbon::setLocale('pl');
        $totalDurationTime = $endTime->diffInMinutes($startTime);

        if(Carbon::parse($startTime)->isCurrentMinute()) return "● Online";
        switch($totalDurationTime){
            case $totalDurationTime<30 || Carbon::parse($startTime)->isCurrentMinute():
                return "● Online";
                break;
            case $totalDurationTime>30 && $totalDurationTime<60:
                return $endTime->diffInMinutes($startTime)." minut od ostatniej aktywności";
                break;
            case $totalDurationTime>=60 && $totalDurationTime < 60*24:
                return $endTime->diffInHours($startTime)." godzin od ostatniej aktywności";
                break;
            case $totalDurationTime>=60*24:
                return $endTime->diffInDays($startTime)." dni od ostatniej aktywności";
                break;

            default:
                return "coś poszło nie tak...";
                break;
        }

    }
}
