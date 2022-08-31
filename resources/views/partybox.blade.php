@extends('layouts.app')
@inject('UsrData',  'App\Http\Controllers\UserCustomController')
@inject('Pcontroller',  'App\Http\Controllers\PartyController')
@section('content')
<div class="partybox-container">
    <div class="partybox-title">
        <div>

            @if(($party[0]->owner_id != Auth::user()->id))
            <h4># Admin: {{$UsrData->getUserDataById($party[0]->owner_id)[0]["nick"]}}</h4>
                <label style="margin-left:8%">dodano: {{$party[0]->created_at}}</label>
            @else
                <h4 style="color: darkred"># Jesteś adminem tej imprezy</h4>
            @endif

            <img class="partybox-image" src="{{\Illuminate\Support\Facades\URL::asset('').$party[0]->image}}">
                @if(($party[0]->owner_id != Auth::user()->id))


                    @if(!$Pcontroller->ifJoined($party[0]->id))
                <form method="post" action="{{route('joinparty', ['id'=>$party[0]->id])}}">
                    @csrf
                <input type="submit" class="header-profile-button" value="➕ Dołącz">
                </form>
                    @else
                        <form method="post" action="{{route('leaveparty', ['id'=>$party[0]->id])}}">
                            @csrf
                            <input type="submit" class="header-profile-button" value="Opuść imprezę">
                        </form>
                    @endif

                @endif
            <h4 class="red-header-pb">Uczestnicy</h4>
                @foreach($Pcontroller->getPartyMembers($party[0]->id) as $single)
                    <label>#{{$UsrData->getUserDataById($single->user_id)[0]["nick"]}}</label>
                @if(($party[0]->owner_id != Auth::user()->id))
{{--   uczestnicy--}}
                @endif
                    @endforeach
        </div>


        <div>
        <label class="partybox-label">Nazwa imprezy</label>
       <h1 class="partybox-title-h1"># {{$party[0]->title}}</h1>
        <div class="partybox-why">⎙ {{$party[0]->why}}</div>
        <div id="timer" class="partybox-why">⏱ {{$party[0]->start_time}}</div>
            <div class="partybox-why">⌖ {{$party[0]->city}}, {{$party[0]->place}}</div>
            <div class="partybox-why">🛇 wiek od lat {{$party[0]->minage}} do {{$party[0]->maxage}}</div>

            @if(!$Pcontroller->ifJoined($party[0]->id) && !$Pcontroller->isOwner($party[0]->id))
            <div style="text-align: center; margin-block:30px; background: #9648b8; border-radius:30px;
             padding-block:10px;" class="center-xx">
                <h1 style="color:white">💬 Dołącz do imprezy, aby dołączyć do konwersacji</h1>

            </div>
            @else
                <div style="text-align: center; margin-block:30px; background: #9648b8; border-radius:30px;
             padding-block:10px;" class="center-xx">
                    <h1 style="color:white">💬 ChatBox</h1>
                </div>
            @endif
        </div>
    </div>
</div>

    <script>

        let time = new Date('{{$party[0]->start_time}}');

        let timer = document.getElementById('timer');
        let diffTime= Math.abs(time - new Date(Date.now()));
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        const diffHours = Math.ceil(diffTime / (1000 * 60 * 60))
        if(diffDays>2) {
            timer.innerHTML = "⏱ " + diffDays + " dni do rozpoczęcia || " + '{{$party[0]->start_time}}';
        }else{
            timer.innerHTML = "⏱ " +diffHours + " godzin do rozpoczęcia" + '{{$party[0]->start_time}}';
        }

    </script>
@endsection
