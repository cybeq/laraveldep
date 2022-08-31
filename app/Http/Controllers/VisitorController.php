<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BlockController;

class VisitorController extends Controller
{
    public function __construct(Request $req){
        $this->middleware('verified');
        $this->req = $req;

    }

    public function friendship(){
        $check = DB::table('followers')
            ->select()->where('user_id_A', Auth::user()->id)
            ->where('user_id_B', $this->req->id)
            ->where('okay', true)
            ->get();
        $check2 = DB::table('followers')
            ->select()->where('user_id_B', Auth::user()->id)
            ->where('user_id_A', $this->req->id)
            ->where('okay', true)
            ->get();
        if(!empty($check[0]) || !empty($check2[0])) return "friends";

    }


    public function visitProfile(Request $request){
       $blockController = new BlockController();
        if($blockController->checkVisitorBlocked($request->id)){return view('blocked');};

        if($request->id == Auth::user()->id) return redirect()->route('profile');
        $user = DB::table('users')->select()
            ->where('id',$request->id)
            ->get();
        if(empty($user[0])) abort(404);
//        else echo json_encode();
        $data = json_decode(json_encode($user), true);
       return view('test')->with(array('user'=>$data[0]));
    }
//funkcja zapraszajaca
    public function inviteProfile(Request $request){
        if(Auth::user()->id == $request->authId)
        {
//            sprawdzenie czy juz zostalo wyslanie zaproszenie
            $check = DB::table('followers')->select( 'user_id_B')
                ->where('user_id_A', $request->userId)
                ->get();

           if(!empty($check[0])){
               DB::table('followers')
                   ->where('user_id_A', $request->userId)
                   ->where('user_id_B', Auth::user()->id)
                   ->update(['okay' => 1]);
               return back()->with(['message'=>'Potwierdzenie zaproszenia']);
           }

// insert jesli zaproszneia nie bylo
            try {
                DB::table('followers')->insert([
                    'user_id_A' => Auth::user()->id,
                    'user_id_B' => $request->userId,
                    'init_key' => $request->userId . Auth::user()->id,
                    'reverse_key' => Auth::user()->id . $request->userId
                ]);
                return back()->with(['message'=>'Zaproszenie wysłane']);
            }catch(\Exception $e){
                return back()->with(['message'=>'Zaprosiłeś już tego imprezowicza. Poczekaj na odpowiedź']);
            }
        }
    }
}
