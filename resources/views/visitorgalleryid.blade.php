@extends('layouts.app')
@inject('UsrData',  'App\Http\Controllers\UserCustomController')
@inject('Comments',  'App\Http\Controllers\CommentController')
@section('content')<div style="text-align: center">
    <button class="header-profile-button" onclick="history.back()">wróć</button>
</div>
    <div  class="galleryid-wrapper">

        <div>

            <div class="profile-show-photo-id">
                <img src="{{\Illuminate\Support\Facades\URL::asset('').$photo[0]->url}}">
            </div><br/>
            <div class="profile-photos-options">

            </div>
        </div>

        <div>
            <div class="profile-comments">
                <h1>Komentarze</h1>
                <div class="profile-comments-section">
                    @if(empty($Comments->getComments($photo[0]->id)))
                        <h2 style="opacity:0.6">Brak komentarzy</h2>
                    @endif
                    @foreach($Comments->getComments($photo[0]->id) as $single)
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
                            @if($single->user_id == \Illuminate\Support\Facades\Auth::user()->id)
                                    <form method="post" action="{{route('deletecommentbyvisitor', ['id'=>$single->id, 'user_id'=>Auth::user()->id, 'photo_id'=>$photo[0]->id])}}">
                                        @csrf
                                        <input type="submit" value="🗑 Usuń">
                                    </form>
                                @endif
                            </div>

                        </div>

                    @endforeach
                </div>
                <form class='comment-form' method="post" action="{{route('addcomment', ['id'=>$photo[0]->id])}}">
                    @csrf
                    <input type="text" name="body">
                    <input type="submit" value="dodaj">
                </form>
            </div>
        </div>
    </div>

@endsection
