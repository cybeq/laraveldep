@inject('PersonalInfo', 'App\Http\Controllers\PersonalInfoController')
@inject('Gallery', 'App\Http\Controllers\GalleryController')
@extends('layouts.app')
@section('content')



        <div class="center-body">

        </div>
{{--        {{print_r($photos)}}--}}

{{--    {{$photos[0]["url"]}}--}}
        <div class="header-profile">
            <a  href="{{route('profile')}}"><button id="impr-button" class="header-profile-button">👤 Profil</button></a>
            <a href="{{route('followers')}}"> <button class="header-profile-button">🔍 Szukaj znajomych</button></a>
            <a href="{{route('lookinvites')}}"> <button class="header-profile-button">🧑‍🤝‍🧑 Zaproszenia</button></a>
            <a href="{{route('profileparty')}}"> <button  class="header-profile-button">🥳 Imprezy</button></a>
            <a href="{{route('mailbox')}}"><button class="header-profile-button">📨 Wiadomości</button></a>
            <a href="{{route('profilegallery')}}"><button class="header-profile-button">📷 Zdjęcia</button></a>
        </div>
        <div class="wrapper-profile">






            <div class="profile-column">


                <div class="add-photo-div" style="margin-top:20px;">
                    <div class="add-photo-photo">

{{--                    @if($photos[0]['avatar']=='images/default.jpg')--}}
{{--                            <img style="margin-right:10px;" class="user-profile-photo" src="{{\Illuminate\Support\Facades\URL::asset($photos[0]['avatar'])}}">--}}
{{--                        <h2>Nie masz zdjęcia profilowego. <br/>Imprezowicze chcą wiedzieć jak wyglądasz</h2><br/>--}}

{{--                    @endif--}}

{{--                    @if($photos[0]['avatar']!='images/default.jpg')--}}
                        <div style="display:block">

                        <div style="display:block">
                        <img class="user-profile-photo-good" src="{{\Illuminate\Support\Facades\URL::asset($photos[0]['avatar'])}}">
                        </div>
                            <div style="display:block">zmień zdjęcie profilowe</div>
                            <div>
                                <form method="post" enctype="multipart/form-data" action="{{route('addphoto')}}">
                                    @csrf
                                    <input id="image-upload" accept="image/*" name="image" type="file">
                                    <input value="Prześlij" type="submit">
                                </form>
                            </div>
                        </div>
{{--                    @endif--}}
                    </div>

                    <div class="add-photo-data">
                        <label class="describe">Nazwa użytkownika</label>
                    <h2>{{ Auth::user()->nick }}</h2>
                        <label class="describe">Adres email</label>
                        <h2>{{ Auth::user()->email}}</h2>
                        <label class="describe">Imię i nazwisko</label>
                        <p>{{ Auth::user()->name}}</p>
                        <label class="describe">Płeć</label>
                        @if(Auth::user()->gender==1)
                        <p>Mężczyzna</p>
                        @else
                        <p>Kobieta</p>
                        @endif
                        <label class="describe">Miejscowość</label>
                        <p>{{ Auth::user()->loc}}</p>
                        <label class="describe">Wiek</label>
                        <p>{{\Carbon\Carbon::parse(Auth::user()->dob)->age}} lat</p>
                    </div>
                    <div class="profile-info">
                      <div id="information-edit">
                        <label onclick="edit()" class="describe" style="color: #0f5132; font-size:1.2em;">Edytuj ✎</label>
                        <h2 style="text-decoration: underline">Informacje</h2>
                        <label class="describe">Alkohol</label>
                        <p class="filled-p">{{$PersonalInfo->getPersonalInfo(Auth::user()->id, 'alcohol')}}</p>
                         <form method="post" action="{{route('savepersonals')}}">
                             @csrf
                          <input value="{{$PersonalInfo->getPersonalInfo(Auth::user()->id, 'alcohol')}}" name="alcohol" maxlength="20" minlength="3" class="to-fill-input" type="text">
                        <label class="describe">Papierosy</label>
                        <p class="filled-p">{{$PersonalInfo->getPersonalInfo(Auth::user()->id, 'smokes')}}</p>
                          <input value="{{$PersonalInfo->getPersonalInfo(Auth::user()->id, 'smokes')}}"  name="smokes" maxlength="20" minlength="3" class="to-fill-input" type="text">
                        <label class="describe">Inne używki</label>
                        <p class="filled-p">{{$PersonalInfo->getPersonalInfo(Auth::user()->id, 'drugs')}}</p>
                          <input value="{{$PersonalInfo->getPersonalInfo(Auth::user()->id, 'drugs')}}" name="drugs" maxlength="20" minlength="3" class="to-fill-input" type="text">
                        <label class="describe">Dzieci</label>
                        <p class="filled-p">{{$PersonalInfo->getPersonalInfo(Auth::user()->id, 'kids')}}</p>
                          <input value="{{$PersonalInfo->getPersonalInfo(Auth::user()->id, 'kids')}}" name="kids" maxlength="20" minlength="3"  class="to-fill-input" type="text">
                             <label class="describe">Praca</label>
                             <p class="filled-p">{{$PersonalInfo->getPersonalInfo(Auth::user()->id, 'job')}}</p>
                             <input value="{{$PersonalInfo->getPersonalInfo(Auth::user()->id, 'job')}}" name="job" maxlength="20" minlength="3"  class="to-fill-input" type="text">
                             <label class="describe">Hobby</label>
                             <p class="filled-p">{{$PersonalInfo->getPersonalInfo(Auth::user()->id, 'hobby')}}</p>
                             <input value="{{$PersonalInfo->getPersonalInfo(Auth::user()->id, 'hobby')}}" name="hobby" maxlength="20" minlength="3"  class="to-fill-input" type="text">
                             <br/><input type="submit" value="Zapisz" class="to-fill-input">
                         </form>
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
                           <a href="{{\Illuminate\Support\Facades\URL::asset('profile/gallery')}}"> <img class="profile-gallery-shorts-small-image" src="{{\Illuminate\Support\Facades\URL::asset('images/plus.png')}}"></a>
                            @foreach($Gallery->getShortVisitorGallery(\Illuminate\Support\Facades\Auth::user()->id) as $photo)
                                <a href="{{\Illuminate\Support\Facades\URL::asset('profile/gallery/show')."/".$photo->id}}"><img class="gallery-photo-list" src="{{\Illuminate\Support\Facades\URL::asset('').$photo->url}}"></a>

                            @endforeach

                        </div>
                    </div>
                </div>
            </div>


        </div>
        <script src="{{\Illuminate\Support\Facades\URL::asset('js/imageProcessor.js')}}"></script>
    <script>
{{--        edycja informacji--}}
    function edit(){
        $(".filled-p").css('display', 'none');
        $(".to-fill-input").css('display', 'inherit');
    }
    </script>

    @endsection

