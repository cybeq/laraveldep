<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserCustomController;
use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class BlockController extends Controller
{
    public function __construct(){
        $this->middleware('verified');
    }
    public function block(Request $request){
        $userController = new UserCustomController();
        if($userController->getUserDataById($request->id)[0]["name"] != $request->name){
            return abort(404);
        }
        $query = DB::table('blocks')->where('blocked_by_id', Auth::user()->id)
            ->where('blocked_id', $request->id)->get()->toArray();
        $query2 = DB::table('blocks')->where('blocked_id', Auth::user()->id)
            ->where('blocked_by_id', $request->id)->get()->toArray();
        if(!empty($query) || !empty($query2)){
          return  abort(404);
        }

        $block = new Block;
        $block->blocked_by_id = Auth::user()->id;
        $block->blocked_id = $request->id;
        $block->save();
        return back();
    }
    public function unlock(Request $request){
        DB::table('blocks')->where('blocked_by_id', Auth::user()->id)
            ->where('blocked_id', $request->id)->delete();
        return back();
    }

    public function checkBlock($id){

        $query = DB::table('blocks')->where('blocked_by_id', Auth::user()->id)
            ->where('blocked_id', $id)->get()->toArray();
        return $query;
    }

    public function checkVisitorBlocked($id){
        $query2 = DB::table('blocks')->where('blocked_id', Auth::user()->id)
            ->where('blocked_by_id', $id)->get()->toArray();
        if(!empty($query2)) return true;
        return false;
    }
    public function goBack(){
        return back();
    }
}
