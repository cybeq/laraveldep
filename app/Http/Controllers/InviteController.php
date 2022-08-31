<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class InviteController extends Controller
{
    public function __construct(){
        $this->middleware('verified');
    }
//    strona z zaproszeniami
    public function page(){
        $invites =  DB::table('followers')
            ->select('user_id_A')
            ->where('user_id_B', Auth::user()->id)
            ->where('okay', false)
            ->get();
        $invites = json_decode(json_encode($invites), true);
        $data=[];
        foreach($invites as &$single){
            foreach($single as $key=> &$value) {
                if ($value == Auth::user()->id) {
                    unset($single[$key]);
                    continue;
                }
                array_push($data, DB::table('users')->select('name','id', 'avatar', 'loc', 'nick')
                    ->where('id', $single[$key])
                    ->get()[0]
                );

            }
        }

        $invites = $data;
        return view('invite')->with(array('invites'=>$invites));
    }
}
