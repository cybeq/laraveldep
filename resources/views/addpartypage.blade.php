@extends('layouts.app')
@inject('UsrData',  'App\Http\Controllers\UserCustomController')

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
        <div class="party-add-party" >
            <div style="width:90%; text-align: left">
                <img src="{{\Illuminate\Support\Facades\URL::asset('images')."/defaultimage.png"}}" id="preview-place">
{{--                <form method="post" enctype="multipart/form-data" action="{{route('savepartyimage', ['partyid'=>1])}}">--}}
{{--                    @csrf--}}
{{--                    <input id="image-upload" accept="image/*" name="image" type="file">--}}
{{--                    <input value="Prześlij" type="submit">--}}
{{--                </form>--}}
                <form method="post"
                      enctype="multipart/form-data"
                      action="{{route('postparty')}}">
                    @csrf
                 <h3>Dodaj zdjęcie dla imprezy</h3>

                    <input id="image-upload" accept="image/*" name="image" type="file">
                    <input value="Prześlij" type="submit">



                    <h3>Gdzie zamierasz imprezować?</h3>
                    <label>Wybierz województwo</label>
                    <select name="region">
                        <option value="Dolnośląskie">Dolnośląskie</option>
                        <option value="Kujawsko-Pomorskie">Kujawsko-Pomorskie</option>
                        <option value="Lubelskie">Lubelskie</option>
                        <option value="Lubuskie">Lubuskie</option>
                        <option value="Łódzkie">Łódzkie</option>
                        <option value="Małopolskie">Małopolskie</option>
                        <option value="Mazowieckie">Mazowieckie</option>
                        <option value="Opolskie">Opolskie</option>
                        <option value="Podkarpackie">Podkarpackie</option>
                        <option value="Podlaskie">Podlaskie</option>
                        <option value="Pomorskie">Pomorskie</option>
                        <option value="Śląskie">Śląskie</option>
                        <option value="Świętokrzyskite">Świętokrzyskite</option>
                        <option value="Warmińsko-Mazurskie">Warmińsko-Mazurskie</option>
                        <option value="Wielkopolskie">Wielkopolskie</option>
                        <option value="Zachodniopomorskie">Zachodniopomorskie</option>
                    </select>
                    @if($errors->city)
                        <script>
                            </script>
                        @endif
                    <label>Miasto</label>
                    <input id="city" name="city" type="text" minlength="3" maxlength="30">
                    <label>Miejsce spotkania ( adres / znana miastowiczom lokalizacja )</label>
                    <input name="place" id="place" type="text" minlength="3" maxlength="90">

                    <label  >Maksymalna liczba uczestników</label>
                    <label style="" id="maks">Liczba</label>
                    <input  id="suwakM" name="minage" type="range" min="1" max="1000">


                    <label  >Minimalny wiek uczestników</label>
                    <label style="" id="wiek">Wiek</label>
                    <input  id="suwak" name="minage" type="range" min="18" max="60">

                    <label  >Maksymalny wiek uczestników</label>
                    <label style="" id="wiekMax">Wiek</label>
                    <input  id="suwak2" name="maxage" type="range" min="18" max="80">

                    <label> Wybierz typ imprezy :
                    <br/>publiczna - otwarta dla każdego<br/> prywatna - uczestnik musi zostać przez Ciebie
                        zaakceptowany
                    </label>
                    <select name="public">
                        <option value="1">Publiczna</option>
                        <option value="0">Prywatna</option>
                    </select>

                    <label>Data i godzina imprezy</label>
                    @if($errors->get('time_early'))
                        <label class="warning">Imprezy w przeszłości jeszcze nie są dostępne. Kontaktujemy się z dilerem.</label>
                        @endif
                    @if($errors->get('time_late'))
                        <label class="warning">Najpóźniej za 20 dni</label>
                        @endif
                    <input id="time" name="start_time" type="datetime-local" >

                    <label>Tytuł imprezy </label>
                    <input minlength="5" maxlength="70" id="title" type="text" style="width:100%" name="title">

                    <label>Opis</label>
                    <input  minlength="5" maxlength="120" id="why" type="text" style="width:100%" name="why">

                    <label>Cel imprezy(opcjonalnie)</label>
                    <input minlength="5" maxlength="70" type="text" name="goad">
                    <br/>
                    <input type="submit" class="header-profile-button" value="Dodaj!">
                </form>


{{--                errors--}}
                @if($errors->get('city'))
                    <script>
                        document.getElementById('city').style.borderColor="red";
                        document.getElementById('city').style.background="#ead0d0";
                        document.getElementById('city').addEventListener('change',()=>{
                            document.getElementById('city').style.borderColor="black";
                            document.getElementById('city').style.background="white";
                        })
                    </script>
                @endif
                @if($errors->get('place'))
                    <script>
                        document.getElementById('place').style.borderColor="red";
                        document.getElementById('place').style.background="#ead0d0";
                        document.getElementById('place').addEventListener('change',()=>{
                            document.getElementById('place').style.borderColor="black";
                            document.getElementById('place').style.background="white";
                        })
                    </script>
                @endif
                @if($errors->get('why'))
                    <script>
                        document.getElementById('why').style.borderColor="red";
                        document.getElementById('why').style.background="#ead0d0";
                        document.getElementById('why').addEventListener('change',()=>{
                            document.getElementById('why').style.borderColor="black";
                            document.getElementById('why').style.background="white";
                        })
                    </script>
                @endif
                @if($errors->get('title'))
                    <script>
                        document.getElementById('title').style.borderColor="red";
                        document.getElementById('title').style.background="#ead0d0";
                        document.getElementById('title').addEventListener('change',()=>{
                            document.getElementById('title').style.borderColor="black";
                            document.getElementById('title').style.background="white";
                        })
                    </script>
                @endif

                @if($errors->get('time'))
                    <script>
                        document.getElementById('time').style.borderColor="red";
                        document.getElementById('time').style.background="#ead0d0";
                        document.getElementById('time').addEventListener('change',()=>{
                            document.getElementById('time').style.borderColor="black";
                            document.getElementById('time').style.background="white";
                        })
                    </script>
                @endif

            </div>
        </div>
<script>
    let input = document.getElementById('suwak');
    let label = document.getElementById('wiek');
    label.innerHTML="<h2>"+input.value+"</h2>";
    input.addEventListener('change', (e)=>{
    label.innerHTML="<h2>"+ e.target.value+"</h2>";

    })

    let input2 = document.getElementById('suwak2');
    let label2 = document.getElementById('wiekMax');
    label2.innerHTML="<h2>"+input2.value+"</h2>";
    input2.addEventListener('change', (e)=>{
        label2.innerHTML="<h2>"+ e.target.value+"</h2>";

    })


    let input3 = document.getElementById('suwakM');
    let label3 = document.getElementById('maks');
    label3.innerHTML="<h2>"+input3.value+"</h2>";
    input3.addEventListener('change', (e)=>{
        label3.innerHTML="<h2>"+ e.target.value+"</h2>";
        if(e.target.value>999){
            label3.innerHTML="<h2>Nieograniczona</h2>";
        }

    })
</script>

        <script>
            let imgupload = document.getElementById('image-upload');
            let blah = document.getElementById('preview-place');
            imgupload.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    blah.src = URL.createObjectURL(file);
                    $('#preview-place').css('max-width','50%')
                    $('#preview-place').css('max-height','400px')
                    $('#preview-place').css('box-shadow', '3px 3px 3px #2d374830')

                }
            });
        </script>
@endsection
