<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowersController extends Controller
{

    public function __construct(){
        $this->middleware('verified');
    }
    public function page(){
        return view('followers');
    }

    public function search(){
        $users = DB::table('users')
            ->select('name', 'nick', 'loc', 'avatar', 'id')
            ->get();
        echo json_encode($users);
    }

    public function getFollowers(){
        $invites =  DB::table('followers')
            ->select('user_id_A', 'user_id_B')
            ->where('okay', true)
            ->where('user_id_B', Auth::user()->id)
            ->orWhere('user_id_A', Auth::user()->id)
            ->where('okay', true)
            ->get();
        $invites = json_decode(json_encode($invites), true);
        $data=[];
        foreach($invites as &$single){
            foreach($single as $key=> &$value) {
                if ($value == Auth::user()->id) {
                    unset($single[$key]);
                    continue;
                }
                array_push($data, DB::table('users')->select('name','id')
                    ->where('id', $single[$key])
                    ->get()[0]
                );

            }
        }

        return $data;




    }
}
