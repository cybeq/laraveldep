@extends('layouts.app')
@section('content')
    <div class="header-profile">
        <a  href="{{route('profile')}}"><button  class="header-profile-button">👤 Profil</button></a>
        <a href="{{route('followers')}}"> <button  class="header-profile-button">🔍 Szukaj znajomych</button></a>
        <a href="{{route('lookinvites')}}"> <button id="impr-button" class="header-profile-button">🧑‍🤝‍🧑 Zaproszenia</button></a>
        <a href="{{route('profileparty')}}"> <button  class="header-profile-button">🥳 Imprezy</button></a>
        <a href="{{route('mailbox')}}"><button class="header-profile-button">📨 Wiadomości</button></a>
        <a href="{{route('profilegallery')}}"><button class="header-profile-button">📷 Zdjęcia</button></a>
    </div>
<div id='invites' class="invites-wrapper">
</div>
@if(empty($invites))
    <div class="empty-invites">
        <h1>Nie masz żadnych nowych zaproszeń</h1>
    </div>
    @endif
    <script>
        var publicDir = '{{\Illuminate\Support\Facades\URL::asset('')}}';
        let invites = '{{json_encode($invites)}}';
        invites = invites.replace(/&quot;/ig,'"');
        invites = JSON.parse(invites);
        let invitesDiv = document.getElementById('invites');
        let authUser = '{{\Illuminate\Support\Facades\Auth::user()->id}}';

        for(let all of invites){
            invitesDiv.innerHTML+="<div class='an-invite'>"+"<div class='an-invite-left'>"+
                "<h3>"+all.name+"</h3>"+
                "<p>"+all.loc+"</p>"+

                "<a href='" + publicDir + "visitor/profile/" +all['id']+ "/" + all['name']+"'>"
                +
                "<button class='see-profile-button' style='background: rgb(92, 94, 154); box-shadow: 3px 3px 3px #5C5E9A30 color: white; border-radius:10px;" +
                "border:none; padding:6px;" +
                "'>Odwiedź profil</button>"+
                "</a>"
                +
                "</div>"+
                "<div style='text-align: right' class='an-invite-right'>" +
                "<img width='90px' height='80px' style='border-radius: 10px; box-shadow: 3px 3px 3px #5C5E9A30' src='" + publicDir +all["avatar"] + "' />"
                +"</div>"

                +"<a href='" + publicDir + "profile/invites/accept/" + authUser + "/" + all['id'] + "'>"
                +"<button  class='accept'>Akceptuj</button></a>"


                +"<a href='" + publicDir + "profile/invites/cancel/" + authUser + "/" + all['id'] + "'>"+
                "<button class='cancel'>Anuluj</button></a>"

                "</div>";
        }
        {{--<form action="{{ route('invite', ['authId' => Auth::user()->id, 'userId'=>$user["id"]]) }}" method="POST" >--}}
        {{--@csrf--}}
    </script>



    @endsection
