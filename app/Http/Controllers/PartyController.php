<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\PartyMan;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidDateException;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;

class PartyController extends Controller
{
    function __construct()
    {
        $this->middleware('verified');
    }

    public function get5Parties(){
        $data = DB::table('party')->select()->get()->take(5)->toArray();
        return array_reverse($data);
    }

    public function profileParty()
    {
        return view('profileparty');
    }

    public function addPartyPage()
    {
        if($this->getOwnerParty()!=null){return redirect()->route('profileparty');};
        return view('addpartypage');
    }

    public function postParty(Request $request)
    {

        if($request->input('city')==null) return back()->withErrors(['city'=>'Wypełnij to pole']);
        if($request->input('place')==null) return back()->withErrors(['place'=>'Wypełnij to pole']);
        if($request->input('title')==null) return back()->withErrors(['title'=>'Wypełnij to pole']);
        if($request->input('why')==null) return back()->withErrors(['why'=>'Wypełnij to pole']);
        if($request->input('region')==null) return back()->withErrors(['region'=>'Wypełnij to pole']);
        if($request->input('start_time')==null) return back()->withErrors(['time'=>'Wypełnij to pole']);

        try{
            Carbon::parse($request->input('start_time'));
        }catch(InvalidFormatException $e){
            return back()->withErrors(['time'=>'Wypełnij to pole']);
        }

        if(Carbon::now()->gt(Carbon::parse($request->input('start_time'))))
        {return back()->withErrors(['time_early'=>'To już było']);};

        if(Carbon::parse($request->input('start_time'))->gt(Carbon::now()->addDays(20))){
            return back()->withErrors(['time_late'=>'Maks 20 dni od dzisiaj']);
        }


        $uploaded = false;
        $party = new Party;
        $party->image = "noimage";
        $party->owner_id = Auth::user()->id;
        $party->region = $request->input('region');
        $party->city = $request->input('city');
        $party->place = $request->input('place');
        $party->minage = $request->input('minage');
        $party->maxage = $request->input('maxage');
        $party->public = $request->input('public');
        $party->start_time = Carbon::parse($request->input('start_time'));
        $party->why = $request->input('why');
        $party->goal = $request->input('goal');
        $party->title = $request->input('title');
        $party->save();


        if ($request->file('image') == null) {
            $file = "";
            $uploaded =false;
        } else {

            $allowedMimeTypes = ['image/jpg', 'image/jpeg', 'image/gif', 'image/png'];
            $contentType = $request->file('image')->getClientMimeType();
            if (!in_array($contentType, $allowedMimeTypes)) {
                return response()->json('error: Not an image');
            }
            $uploaded = true;
        }

        if($uploaded) {
            $manager = new ImageManager(['driver' => 'imagick']);

// read image from file system
            $image = $manager->make($request->file('image'));


//
            $height = $image->height();
            $width = $image->width();
            while ($height > 900) {
                $height *= 0.9;
                $width *= 0.9;
            }
            while ($width > 900) {
                $height *= 0.9;
                $width *= 0.9;
            }
            $image->resize($width, $height);


            $image->encode('jpg', 75);


            $image->save('images/' . self::generateRandomString(40) . '.jpg');

            $thisarray = DB::table('party')->select('id')->where('owner_id', Auth::user()->id)
                ->latest('created_at')->first();
            $party_id = $thisarray->id;
//        'images/'.$image->basename;
            DB::table('party')->where('id', $party_id)->
            update(['image' => 'images/' . $image->basename]);

        }
            return redirect()->route('profileparty');
    }


    public static function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return "party_".$randomString;
    }

    public function getOwnerParty(){
        $parties = DB::table('party')->where('owner_id', Auth::user()->id)
            ->select()->first();
        return $parties;
    }

    public function deleteParty(Request $request){
        $party_id = $request->party_id;

        DB::table('party')->where('id', $party_id)
            ->where('owner_id', Auth::user()->id)->delete();
        return redirect()->route('profileparty');
    }

    public function showPartyManager(){
        return view('partymanager');
    }

    public function getPartyBox(Request $request){
        $party = DB::table('party')->where('id', $request->id)->select()->get()->toArray();
        if(empty($party)) return abort(404);
        if($request->title != $party[0]->title) return abort(404);

        return view('partybox')->with(['party'=>$party]);
    }

    public function join(Request $request){
        $check = DB::table('partypeople')->select()->where('user_id', Auth::user()->id)
            ->where('party_id', $request->id)
            ->get()->toArray();
        if(!empty($check)) return redirect()->route('home');

        $partyMan = new PartyMan;
        $partyMan->user_id = Auth::user()->id;
        $partyMan->party_id = $request->id;
        $partyMan->save();
        return back();
    }
    public function leave(Request $request){
        $check = DB::table('partypeople')->select()->where('user_id', Auth::user()->id)
            ->where('party_id', $request->id)
            ->get()->toArray();
        if(empty($check)) return redirect()->route('home');

        DB::table('partypeople')->where('user_id',Auth::user()->id)
            ->where('party_id', $request->id)->delete();
        return back();
    }


    public function ifJoined($party_id){
       $check = DB::table('partypeople')->select()->where('user_id', Auth::user()->id)
           ->where('party_id', $party_id)
           ->get()->toArray();
       if(empty($check)) return false;
       return true;
    }

    public function isOwner($id){
        $check = DB::table('party')->select('owner_id')->where('id', $id)->select()
            ->first();

        if($check->owner_id == Auth::user()->id) return true;
        return false;

    }

    public function getPartyMembers($id){
        $people= DB::table('partypeople')->select()->where('party_id', $id)->get()
            ->toArray();
        return $people;
    }

    public function getUserParties(){
        $parties= DB::table('partypeople')->where('user_id', Auth::user()->id)
            ->select()->get()->toArray();
        return $parties;
    }

    public function getPartyDataById($id){
        $data = DB::table('party')->where('id', $id)->select()->first();
        return $data;
    }

}
