@inject('Gallery', 'App\Http\Controllers\GalleryController')
@inject('UsrData',  'App\Http\Controllers\UserCustomController')
@extends('layouts.app')
@section('content')

    <div class="gallery-visitor-wrapper">
        @if(!empty($photos[0]->user_id))
        <h2>Galeria - {{$UsrData->getUserDataById($photos[0]->user_id)[0]["name"]}} - PH</h2>
        @endif
    <div class="gallery-start">

        @foreach($photos as $photo)
            <a href="{{\Illuminate\Support\Facades\URL::to('visitor/profile/gallery/show')."/".$photo->id."/".$photo->user_id."/".$UsrData->getUserDataById($photo->user_id)[0]["name"]}}"><img class="gallery-photo-list" src="{{\Illuminate\Support\Facades\URL::asset('').$photo->url}}"></a>

        @endforeach
        @if(empty($photos))
            <h2>Użytkownik nie ma zdjęć</h2>
        @endif
    </div>
    </div>



@endsection
