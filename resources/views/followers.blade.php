@extends('layouts.app')
@section('content')
@inject('Followers', 'App\Http\Controllers\FollowersController')
<div class="header-profile">
    <a  href="{{route('profile')}}"><button  class="header-profile-button">👤 Profil</button></a>
    <a href="{{route('followers')}}"> <button id="impr-button" class="header-profile-button">🔍 Szukaj znajomych</button></a>
    <a href="{{route('lookinvites')}}"> <button class="header-profile-button">🧑‍🤝‍🧑 Zaproszenia</button></a>
    <a href="{{route('profileparty')}}"> <button  class="header-profile-button">🥳 Imprezy</button></a>
    <a href="{{route('mailbox')}}"><button class="header-profile-button">📨 Wiadomości</button></a>
    <a href="{{route('profilegallery')}}"><button class="header-profile-button">📷 Zdjęcia</button></a>
</div>
<div class="follower-full">
<h2>Znajdź imprezowicza</h2>
<input type="search" id="searchInput">
<div id="users-list" class="users-list">

</div>

<h2>Twoi znajomi</h2>
<div id="followers-list">
@if(empty($Followers->getFollowers()))
Nie masz żadnych znajomych. Imprezuj i zdobądź nowych towarzyszy
@endif
</div>

{{--{{json_encode($Followers->getFollowers(), true)}}--}}

<script>

        let followers = "{{json_encode($Followers->getFollowers(), true)}}";
        followers = followers.replace(/&quot;/ig,'"');
        let data = JSON.parse(followers);

        for(let all of data){
            var link = '{{\Illuminate\Support\Facades\URL::asset('')}}' +'visitor/profile/'
                + all["id"] + "/"+ all['name'];
            document.getElementById('followers-list').innerHTML+="<a href='" + link +"'>"+
                "<p class='p-small-margin'>"+all.name+"</p></a>";
        }


</script>


{{--skrypt z wyszukiwarka--}}
<script>
//
// career@loandogroup.com
        var publicDir = '{{\Illuminate\Support\Facades\URL::asset('')}}';
        let searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keypress', function(e){
            document.getElementById('users-list').innerHTML="";
            var result = '{{ $Followers->search() }}';
            result = JSON.parse(result)
            let data =[];
            for(let single of result){
                if(single["name"].toLowerCase().includes(e.target.value.toLowerCase())
                    ||single["loc"].toLowerCase().includes(e.target.value.toLowerCase())
                    ||single["nick"].toLowerCase().includes(e.target.value.toLowerCase())
                ){
                    // alert(publicDir);
                    data.push(single);
                    if(data.length>15) break;
                }
            }
            for(let i=0; i<data.length; i++) {
                var link = '{{\Illuminate\Support\Facades\URL::asset('')}}' +'visitor/profile/'
                    + data[i]["id"] +"/" +data[i]['name'] ;
                document.getElementById('users-list').innerHTML +=
                    "<div class='user-list-user'><a href='"+ link+"'><h1>" +
                    data[i]["name"] + "</h1><br/>"
                    + "<img class='user-list-avatar' src='" + publicDir +data[i]["avatar"] + "' />"

                    +"#"+data[i]['nick']
                    +"<br/><h3>"+data[i]['loc'] +
                    "</h3></a></div>" ;

            }
            if(e.target.value==="") document.getElementById('users-list').innerHTML ="";
        })

</script>
</div>
@endsection
