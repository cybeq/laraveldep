@extends('layouts.app')
@inject('Visitor', 'App\Http\Controllers\VisitorController')
@inject('UsrData',  'App\Http\Controllers\UserCustomController')

@section('content')

    <div class="header-profile">
        <a href="{{route('followers')}}"> <button class="header-profile-button">✉Wyślij wiadomość</button></a>
        <button id="impr-button" class="header-profile-button">♡Zaproś na imprezę</button>
        <button class="header-profile-button">⚔Zablokuj</button>

    </div>
<div class="visitor-container">
    <div class="visitor-column">
    <h1 class="fellows" style="color:#f9f9f9">{{$user["name"]}} <span id="smaller-visitor-online">{{$UsrData->lastTimeOnline($user['id'])}}</span> </h1>
    <img class='visitor-avatar' src="{{\Illuminate\Support\Facades\URL::asset('').$user["avatar"]}}">
{{--    <a href="{{\Illuminate\Support\Facades\URL::asset('/visitor/profile/invite/').'/'.$user["id"]."/".Auth::user()->id}}"><button>Zapros</button></a>--}}

    </div>
    <div class="visitor-column">
        <h2>Dane imprezowicza</h2>
        <p>Miejscowość</p>
        <p>{{$user["loc"]}}</p>

        <p>Płeć</p>
        @if($user['gender']==1)
            <p>Mężczyzna</p>
        @else
            <p>Kobieta</p>
        @endif

        <p>Wiek: {{\Carbon\Carbon::parse($user['dob'])->age}} lat</p>
{{--znajomi--}}
        @if($Visitor->friendship()!='friends')
            <form action="{{ route('invite', ['authId' => Auth::user()->id, 'userId'=>$user["id"]]) }}" method="POST" >
                @csrf
                <input value="👥 Zaproś do znajomych" type="submit">
            </form>
        @else <br/> <h2 class="fellows">{{__('Jesteście znajomymi')}}</h2>
        @endif
        @if(Session::has('message'))
            {{Session::get('message')}}
        @endif
    </div>
</div>
@if($UsrData->lastTimeOnline($user['id'])==="● Online")
<script>
    document.getElementById('smaller-visitor-online').style.color='#6d9990';
</script>
@endif
@endsection

