@extends('layouts.app')
@inject('UsrData',  'App\Http\Controllers\UserCustomController')
@inject('Party', 'App\Http\Controllers\PartyController')
@section('content')
    <div class="header-profile">
        <a  href="{{route('profile')}}"><button  class="header-profile-button">👤 Profil</button></a>
        <a href="{{route('followers')}}"> <button class="header-profile-button">🔍 Szukaj znajomych</button></a>
        <a href="{{route('lookinvites')}}"> <button class="header-profile-button">🧑‍🤝‍🧑 Zaproszenia</button></a>
        <a  href="{{route('profileparty')}}"> <button id="impr-button" class="header-profile-button">🥳 Imprezy</button></a>
        <a href="{{route('mailbox')}}"><button class="header-profile-button">📨 Wiadomości</button></a>
        <a href="{{route('profilegallery')}}"><button class="header-profile-button">📷 Zdjęcia</button></a>
    </div>

    <div class="party-wrapper">
        <div class="party-add-party">
            @if($Party->getOwnerParty()==null)
            <div>
        <h1>Nie prowadzisz żadnej imprezy!</h1>
       <a href="{{\Illuminate\Support\Facades\URL::asset('/profile/party/add')}}"><button  class="header-profile-button">Dodaj imprezę</button></a>
            </div>
            @else
                <div>
        <h1>1/1</h1>
                    <img class='party-icon' src="{{\Illuminate\Support\Facades\URL::asset('').$Party->getOwnerParty()->image}}" >
                    <label>Twoja impreza</label>
                    <h1>{{$Party->getOwnerParty()->title}}</h1>
                    <label>Zaczynacie</label>
                    <h1>{{$Party->getOwnerParty()->start_time}}</h1>
                    <label>w mieście</label>
                    <h1>{{$Party->getOwnerParty()->city}}</h1>
                    <a href="{{\Illuminate\Support\Facades\URL::asset('partybox')."/".$Party->getOwnerParty()->id."/".$Party->getOwnerParty()->title}}"><button style="border-radius:35px;"  class="header-profile-button">✍ Zarządzaj</button></a>

                    <form style=" display:inline;" method="post" action="{{route('deleteparty', ['party_id'=>$Party->getOwnerParty()->id])}}">
                        @csrf
                    <input style="border-radius:35px;" type="submit" id="red" class="header-profile-button" value="🗑 Usuń">
                    </form>
                </div>
            @endif
        </div>

        <div class="party-yours-party">
            <div>
@if(empty($Party->getUserParties()))
                <h1>Nie uczestniczysz w żadnej imprezie
                </h1>
                    <button  class="header-profile-button">Szukaj imprez</button>
                @else
                    <h1>Uczestniczysz w imprezach
                    </h1>
                    @foreach($Party->getUserParties() as $single)
                <a href="{{\Illuminate\Support\Facades\URL::asset('partybox')."/".$single->party_id."/".$Party->getPartyDataById($single->party_id)->title}}">
                <button class="header-profile-button">{{$Party->getPartyDataById($single->party_id)->title}}</button>
                </a>
                    @endforeach

                @endif


            </div>
        </div>

    </div>

@endsection
