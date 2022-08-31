
@inject('Gallery', 'App\Http\Controllers\GalleryController')
@inject('Comments', 'App\Http\Controllers\CommentController')
@inject('UsrData',  'App\Http\Controllers\UserCustomController')
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
    <div  class="galleryid-wrapper">
        <div>

        <div class="profile-show-photo-id">
        <img src="{{\Illuminate\Support\Facades\URL::asset('').$Gallery->getPhotoById($id)[0]->url}}">
        </div><br/>
            <div class="profile-photos-options">
                <form method="post" action="{{route('deletephoto', ['id'=>$id, 'user_id'=>Auth::user()->id])}}">
                    @csrf
                    <input type="submit" style="background: linear-gradient(148deg, rgba(44,45,134,1) 0%, rgba(221,51,88,0.8288048495765494) 49%);" value="🗑 Usuń" class="header-profile-button">
                </form>

            </div>
        </div>

        <div>
        <div class="profile-comments">
            <h1>Komentarze</h1>
            <div class="profile-comments-section">
                @if(empty($Comments->getComments($id)))
                    <h2 style="opacity:0.6">Brak komentarzy</h2>
                    @endif
                @foreach($Comments->getComments($id) as $single)
                    <div class="single-comment">
                        <div class="single-comment-author">
                            <div class="single-comment-author-avatar-div">
                            <img class="single-comment-author-avatar" src="{{\Illuminate\Support\Facades\URL::asset('')}}{{$UsrData->getUserDataById($single->user_id)[0]['avatar']}}">
                            </div>
                            <div class="single-comment-author-nick-div">
                               # {{$UsrData->getUserDataById($single->user_id)[0]['nick']}}
                            </div>

                        </div>
                        <div class="single-comment-body"> {{$single->body}}</div>
                        <div class="single-comment-options">
                            <form method="post" action="{{route('deletecomment', ['id'=>$single->id, 'user_id'=>Auth::user()->id, 'photo_id'=>$id])}}">
                                @csrf
                                <input type="submit" value="🗑 Usuń">
                            </form>
                        </div>

                    </div>

                @endforeach
            </div>
            <form class='comment-form' method="post" action="{{route('addcomment', ['id'=>$id])}}">
                @csrf
                <input type="text" name="body">
                <input type="submit" value="dodaj">
            </form>
        </div>
    </div>
    </div>

@endsection
