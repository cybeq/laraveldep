<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'id';
    protected $fillable = ['body', 'subject', 'sent_to_id', 'sender_id'];
    use HasFactory;

    public function getLastMessage($reqId){
        return json_encode(self::query()->select()
            ->where('sender_id', Auth::user()->id)
            ->where('sent_to_id', $reqId)
            ->orWhere('sent_to_id', Auth::user()->id)
            ->where('sender_id', $reqId)
            ->get()->reverse()->first(), true);
    }
    public function getUnSeen(){
        return json_encode(self::query()->select('sender_id')
            ->orWhere('sent_to_id', Auth::user()->id)
            ->where('seen', 0)
            ->get(), true);

    }

    public function getLastConversations(){
        return self::query()->select('sender_id', 'sent_to_id')
            ->where('sent_to_id', Auth::user()->id)
            ->orWhere('sender_id', Auth::user()->id)
            ->get()->reverse()->toArray();
    }

}
