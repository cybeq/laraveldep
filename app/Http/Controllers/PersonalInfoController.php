<?php

namespace App\Http\Controllers;

use App\Models\PersonalInfoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersonalInfoController extends Controller
{

    public function __construct(){
        $this->middleware('verified');
    }

    public function addInfo(Request $request){
        DB::table('personal')->select()->where('user_id', Auth::user()->id)
            ->delete();
        $info = new PersonalInfoModel;
        $data = [];
        if(empty($request->input('alcohol'))) $data['alcohol'] = "Brak danych";
        else $data['alcohol'] = $request->input('alcohol');
        if(empty($request->input('smokes'))) $data['smokes'] = "Brak danych";
        else $data['smokes'] = $request->input('smokes');
        if(empty($request->input('kids'))) $data['kids'] = "Brak danych";
        else $data['kids'] = $request->input('kids');
        if(empty($request->input('drugs'))) $data['drugs'] = "Brak danych";
        else $data['drugs'] = $request->input('drugs');
        if(empty($request->input('job'))) $data['job'] = "Brak danych";
        else $data['job'] = $request->job;
        if(empty($request->input('hobby'))) $data['hobby'] = "Brak danych";
        else $data['hobby'] = $request->input('hobby');

        $info->alcohol = $data['alcohol'];
        $info->smokes = $data['smokes'];
        $info->kids = $data['kids'];
        $info->job = $data['job'];
        $info->drugs = $data['drugs'];
        $info->hobby= $data['hobby'];
        $info->user_id = Auth::user()->id;
        $info->save();
        return back();
    }
    public function getPersonalInfo($id, $tag){
        $get = DB::table('personal')->where('user_id', $id)
            ->select($tag)->get()->toArray();
        if(empty($get)) return "Brak danych";
        return $get[0]->$tag;
    }
}
