@inject('Gallery', 'App\Http\Controllers\GalleryController')
@extends('layouts.app')
@section('content')
    <div class="header-profile">
        <a  href="{{route('profile')}}"><button class="header-profile-button">👤 Profil</button></a>
        <a href="{{route('followers')}}"> <button class="header-profile-button">🔍 Szukaj znajomych</button></a>
        <a href="{{route('lookinvites')}}"> <button class="header-profile-button">🧑‍🤝‍🧑 Zaproszenia</button></a>
        <a href="{{route('profileparty')}}"> <button  class="header-profile-button">🥳 Imprezy</button></a>
        <a href="{{route('mailbox')}}"><button class="header-profile-button">📨 Wiadomości</button></a>
        <a href="{{route('profilegallery')}}"><button  id="impr-button" class="header-profile-button">📷 Zdjęcia</button></a>
    </div>
    <div  class="invites-wrapper">
        <button onclick="showForm()" id="add-the-img" class="add-photo-button">+ Dodaj zdjęcie</button>
        <div id="gallery-add-photo">

            <h1></h1>
            <div>
                <h1>{{count($Gallery->getGallery())}}/10</h1>
        @if(count($Gallery->getGallery())<10)
         <img src="{{\Illuminate\Support\Facades\URL::asset('images')."/defaultimage.png"}}" id="preview-place">

            <form method="post" enctype="multipart/form-data" action="{{route('savegallery')}}">
            @csrf
            <input id="image-upload" accept="image/*" name="image" type="file">
            <input value="Prześlij" type="submit">
        </form>
            @endif
        </div>
    </div><h1>Galeria</h1>
        <div class="gallery-start">

            @foreach($Gallery->getGallery() as $photo)
                <a href="{{\Illuminate\Support\Facades\URL::to('profile/gallery/show')."/".$photo->id}}"><img class="gallery-photo-list" src="{{\Illuminate\Support\Facades\URL::asset('').$photo->url}}"></a>
            @endforeach
            @if(empty($Gallery->getGallery()))
                <h2>Nie masz zdjęć</h2>
                @endif
        </div>
    <script>
        let x= true;
        function showForm() {
            if(x){
            $('#gallery-add-photo').css('display', 'inherit')
            $('#add-the-img').html("▲ schowaj")
                x=false;
                }else{
                $('#gallery-add-photo').css('display', 'none')
                $('#add-the-img').html("+ Dodaj zdjęcie")
                x=true;
            }
            }
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
