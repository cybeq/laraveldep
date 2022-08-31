@inject('PersonalInfo', 'App\Http\Controllers\PersonalInfoController')
@inject('UsrData',  'App\Http\Controllers\UserCustomController')
@inject('Gallery',  'App\Http\Controllers\GalleryController')
@inject('Visitor', 'App\Http\Controllers\VisitorController')
@inject('Blocker', 'App\Http\Controllers\BlockController')
@extends('layouts.app')
@section('tytul','Galeria - '.$user['name'].' - PartyHub')
@section('content')



    <div class="center-body">

    </div>

    <div class="header-profile">

        <a href="{{\Illuminate\Support\Facades\URL::asset('/profile/messages')."/".$user['id']."/1/".$user['name']}}"> <button class="header-profile-button">✉Wyślij wiadomość</button></a>
        <button  class="header-profile-button">♡Zaproś na imprezę</button>

        @if($Visitor->friendship()!='friends')
            <form style="display: inline" action="{{ route('invite', ['authId' => Auth::user()->id, 'userId'=>$user["id"]]) }}" method="POST" >
                @csrf
        <input type="submit" style="padding:20px;
    border:0;
    border-radius: 20px;
    width: 150px;
    margin-top:8px;" value="🍺 Zaproś do znajomych" class="header-profile-button">
            </form>

        @else  <button  class="header-profile-button">👥Znajomi</button>
        @endif
        @if(empty($Blocker->checkBlock($user["id"])))
            <form style="display: inline" method="post" action="{{route('blockuser', ['id'=>$user["id"], 'name'=>$user["name"]])}}">
                @csrf
                <input style="background:darkred" type="submit" value="⚔Zablokuj" class="header-profile-button">
            </form>
        @else
            <form style="display: inline" method="post" action="{{route('unlockuser', ['id'=>$user["id"], 'name'=>$user["name"]])}}">
                @csrf
                <input  type="submit" value="⚔ Odblokuj" class="header-profile-button">
            </form>
        @endif

    </div>
    @if(Session::has('message'))
    <div style="text-align: center; margin-top:20px;"> <h2 style="box-shadow: 3px 3px 3px #00000020; padding: 10px;background: #0c412810"> {{Session::get('message')}}</h2> </div>
    @endif
    <div class="wrapper-profile">






        <div class="profile-column">


            <div class="add-photo-div" style="margin-top:20px;">
                <div class="add-photo-photo">
                    <img  id="img-content" alt="">
                        <img class="user-profile-photo-good" src="{{\Illuminate\Support\Facades\URL::asset('')}}{{$user['avatar']}}">
                </div>

                <div class="add-photo-data">
                    @if(!empty($Blocker->checkBlock($user["id"])))
                        <h3 style="color:darkred; margin-bottom:-10px;">🔒<br/>Użytkownik jest przez Ciebie zablokowany!</h3>
                        <p style="color:darkred">Nie może do Ciebie pisać, ani odwiedzać profilu</p>
                    @endif
                    <p id="smaller-visitor-online">{{$UsrData->lastTimeOnline($user['id'])}}</p>
                    <label class="describe">Nazwa użytkownika</label>
                    <h2>#{{$user['nick']}}</h2>
                    <label class="describe">Adres email</label>
                    <h2>
                    @for($i=0; $i<strlen($user['email']); $i++)
                        *
                        @endfor
                    </h2>
                    <label class="describe">Imię i nazwisko</label>
                    <p>{{$user['name']}}</p>
                    <label class="describe">Płeć</label>
                    @if($user['gender']==1)
                        <p>Mężczyzna</p>
                    @else
                        <p>Kobieta</p>
                    @endif
                    <label class="describe">Miejscowość</label>
                    <p>{{$user['loc']}}</p>
                    <label class="describe">Wiek</label>
                    <p>{{\Carbon\Carbon::parse($user['dob'])->age}} lat</p>
                </div>
                <div class="profile-info">
                    <div id="information-edit">
                        <label onclick="edit()" class="describe" style="color: #0f5132; font-size:1.2em;">#</label>
                        <h2 style="text-decoration: underline">Informacje</h2>
                        <label class="describe">Alkohol</label>
                        <p>{{$PersonalInfo->getPersonalInfo($user['id'], 'alcohol')}}</p>


                            <label class="describe">Papierosy</label>
                            <p >{{$PersonalInfo->getPersonalInfo($user['id'], 'smokes')}}</p>
                            <label class="describe">Inne używki</label>
                            <p>{{$PersonalInfo->getPersonalInfo($user['id'], 'drugs')}}</p>
                            <label class="describe">Dzieci</label>
                            <p >{{$PersonalInfo->getPersonalInfo($user['id'], 'kids')}}</p>
                            <label class="describe">Praca</label>
                            <p >{{$PersonalInfo->getPersonalInfo($user['id'], 'job')}}</p>
                            <label class="describe">Hobby</label>
                            <p>{{$PersonalInfo->getPersonalInfo($user['id'], 'hobby')}}</p>
                           <br/>
                    </div>



                    <div>
                        <label class="describe" style="color: #0f5132; font-size:1.2em; cursor: inherit">@</label>
                        <h2 style="text-decoration: underline">Ostatnie aktywności</h2>
                        <label class="describe">Imprezy</label>
                        <p>Brak danych</p>
                        <label class="describe">Komentarze</label>
                        <p>Brak danych</p>
                        <label class="describe">Inne używki</label>
                        <p>Brak danych</p>
                        <label class="describe">Inne używki</label>
                        <p>Brak danych</p>
                    </div>
                </div>
                <div class="profile-gallery-shorts">
                    <h2>Galeria zdjęć</h2>
                    <div>
                    @foreach($Gallery->getShortVisitorGallery($user['id']) as $photo)
                            <a href="{{\Illuminate\Support\Facades\URL::to('visitor/profile/gallery/show')."/".$photo->id."/".$photo->user_id."/".$UsrData->getUserDataById($photo->user_id)[0]["name"]}}"><img class="gallery-photo-list" src="{{\Illuminate\Support\Facades\URL::asset('').$photo->url}}"></a>

                        @endforeach
                        @if(count($Gallery->getShortVisitorGallery($user['id']))<1)
                            <h1>Użytkownik nie ma zdjęć</h1>
                            @endif
                      </div>
                </div>
            </div>
        </div>


    </div>
    <script src="{{\Illuminate\Support\Facades\URL::asset('js/imageProcessor.js')}}"></script>

    @if($UsrData->lastTimeOnline($user['id'])==="● Online")
        <script>
            document.getElementById('smaller-visitor-online').style.color='#6d9990';
        </script>
    @endif
@endsection

