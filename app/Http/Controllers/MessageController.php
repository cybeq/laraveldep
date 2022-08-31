<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BlockController;
use App\Http\Controllers\UserCustomController;
use App\Models\Block;
use http\Message\Body;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public int $requestId=0;
    private Request $req;

    public function __construct(Request $request){
        $this->middleware('verified');
        if(isset($request->id)) {
            $this->requestId = $request->id;
            $this->req = $request;
        }

    }
    public function sendMessage(Request $request )
    {
        if(empty($request->input('body'))){
            return back()->with(['message'=>'fill']);
        }

        $message = new Message;

        $message->body = $request->input('body');
        $message->subject = 'message';
        $message->sender_id = Auth::user()->id;
        $message->sent_to_id = $request->get('sent_to_id');
        $message->save();

//        $message = Message::create([
//          'body' =>  $request->input('body'),
//          'subject' => 'message',
//          'sender_id' => Auth::user()->id,
//          'sent_to_id' =>$request->get('sent_to_id')
//      ]);
        return back();
    }
    public function getRequestId(){
        return $this->requestId;
    }
    public function getRequest(){
        return $this->req;
    }
    public function firstPage(){
        return redirect()->route('mailbox.id', ['id'=>$this->getRequestId(), 'page'=>1]);
    }
    public function showMailBox(Request $request){




        if(isset($request->id) && isset($request->name)) {
//           make message seen
            $customController = new UserCustomController();

            if($request->name != $customController->getUserDataById($request->id)[0]['name'])
            { abort(404);};

             $this->iSawMessage($request);

            $query = DB::table('messages')->select()
                ->where('sender_id', Auth::user()->id)
                ->where('sent_to_id', $request->id)->latest()->take($request->page*50)
                ->orWhere('sent_to_id', Auth::user()->id)
                ->where('sender_id', $request->id)->latest()->take($request->page*50)
                ->get();
            $messages = json_decode(json_encode($query), true);

            $blockController = new BlockController();

            if($blockController->checkVisitorBlocked($request->id)){
                return view('messages')->with(array('messages' => array_reverse($messages), 'warning'=>'Użytkownik Cię zablokował'));
            }
            if($blockController->checkBlock($request->id)){
                return view('messages')->with(array('messages' => array_reverse($messages), 'warning'=>'Zablokowałeś tego użytkownika'));
            }
            return view('messages')->with(array('messages' => array_reverse($messages)));
        }
        else return view('messages');
    }
    public function getLastMessage(Request $request){
        $message = new Message;
         return $message->getLastMessage($request->id);



    }
    public function showUnSeen(){
        $message = new Message;
        $message = json_decode($message->getUnSeen());
        $array =[];

        foreach ($message as $single){
            foreach($single as $value) {
                array_push($array, $value);
            }
        }
        return json_encode(array_unique($array));
    }

    public function iSawMessage(Request $request){

        DB::table('messages')->where('sent_to_id', Auth::user()->id)
            ->where('sender_id', $request->id)
            ->update(['seen'=>1]);
    }

    public function getLastConversations(){
        $message = new Message;
        $message = $message->getLastConversations();
        $array =[];

        foreach ($message as $single){
            foreach($single as $value) {
                array_push($array, $value);
            }
        }
       foreach($array as $key => &$item){
           if($item == Auth::user()->id) unset($array[$key]);
       }
        return array_slice(array_unique($array),0, 10);
    }
}
