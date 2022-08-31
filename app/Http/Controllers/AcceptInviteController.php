<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Integer;

class AcceptInviteController extends Controller
{
    public function __construct()
    {
    $this->middleware('verified');
    }

    public function acceptInvite(Request $request){
        if($request->id_A!=Auth::user()->id) abort(404);

        $key = $request->id_A.$request->id_B;
        $key = (int) $key;
        $query = DB::table('followers')
            ->where('init_key', $key)
            ->update(['okay' => true]);
        return back();

    }
    public function cancelInvite(Request $request){
        if($request->id_A!=Auth::user()->id) abort(404);

        $key = $request->id_A.$request->id_B;
        $key = (int) $key;
        $query = DB::table('followers')
            ->where('init_key', $key)
            ->delete();
        return back();

    }
}
