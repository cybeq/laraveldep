@extends('layouts.app')
@inject('Followers', 'App\Http\Controllers\FollowersController')
@inject('UsrData',  'App\Http\Controllers\UserCustomController')
@inject('MessageModel', 'App\Http\Controllers\MessageController')

@section('content')
    <div class="header-profile">
        <a  href="{{route('profile')}}"><button  class="header-profile-button">👤 Profil</button></a>
        <a href="{{route('followers')}}"> <button  class="header-profile-button">🔍 Szukaj znajomych</button></a>
        <a href="{{route('lookinvites')}}"> <button  class="header-profile-button">🧑‍🤝‍🧑 Zaproszenia</button></a>
        <a href="{{route('profileparty')}}"> <button  class="header-profile-button">🥳 Imprezy</button></a>
        <a href="{{route('mailbox')}}"><button id="impr-button" class="header-profile-button">📨 Wiadomości</button></a>
        <a href="{{route('profilegallery')}}"><button class="header-profile-button">📷 Zdjęcia</button></a>
    </div>
    <div class="total" id="total">
    <div class="messages-wrapper">
        <div class="left-side">
            <label>Nowe wiadomości</label>
            <div id="new-messages" class="messages-followers"></div>


            <label>Twoi znajomi</label>
            <div id="messages-followers" class="messages-followers"></div>

            <label>Ostatnie konwersacje</label>
            <div id="last-messages" class="messages-followers">
                @foreach($MessageModel->getLastConversations() as $single)
                    <a href="{{\Illuminate\Support\Facades\URL::asset('').'profile/messages/'.$single.'/1/'.$UsrData->getUserDataById($single)[0]['name']}}" >
                    <p>{{$UsrData->getUserDataById($single)[0]["name"]}}</p></a>
                @endforeach

            </div>



            <div class="messages-tasks"></div>
        </div>
        <div class="right-side">
        @if(Route::is('mailbox'))
            <div class="search-messages-user">
                <h2>Znajdź użytkownika</h2>
            <input type="search" id="searchInput">

            <div id="users-list" class="users-list">

            </div>
            </div>
        @endif
            <div class="messages-content">
            @if(Route::is('mailbox.id'))
                <div class="label">
                    <img class='avatar-message-header'  src="{{\Illuminate\Support\Facades\URL::asset('').$UsrData->getUserDataById($MessageModel->getRequestId())[0]['avatar']}}" style="float:right">
                   <h2 style="display: inline"> {{$UsrData->getUserDataById($MessageModel->getRequestId())[0]['name']}}</h2>

                    @if($UsrData->lastTimeOnline($MessageModel->getRequestId())==="● Online")
                        <p style="display: inline; color: #0f5132">
                        {{$UsrData->lastTimeOnline($MessageModel->getRequestId())}}
                            @else
                        <p style="display: inline; color: #5c636a">
                                {{$UsrData->lastTimeOnline($MessageModel->getRequestId())}}
                    @endif
                    </p>
                    <p>#{{$UsrData->getUserDataById($MessageModel->getRequestId())[0]['nick']}}</p>

                </div>

                <div id="get-messages">
{{--                    czyjes wiadomosci--}}
{{--                    {{json_encode($messages)}}--}}
                </div>
                    <div id="write-message">
                        @if(isset($warning))
                            <div style="text-align: center; color: darkred;"> {{$warning}}</div>
                        @endif
                        @if(!isset($warning))
                        <form action="{{route('sendmessage', ['sent_to_id'=>$MessageModel->getRequestId()])}}" method="post">
                            @csrf
                        <input type="text" name="body" id="body">
                            <input type="submit">
                        </form>
                            @endif
                    </div>


                @else
                <div id="blank-mailbox"></div>
                @endif

            </div>
        </div>

    </div>
    </div>
{{--    followers--}}
{{--    trzeba dodac name do wiadomosci, dla security--}}
    <script>
        let followers = "{{json_encode($Followers->getFollowers(), true)}}";
        followers = followers.replace(/&quot;/ig,'"');
        let data = JSON.parse(followers);
        for(let all of data){
            var link = '{{\Illuminate\Support\Facades\URL::asset('')}}' +'profile/messages/'
                + all["id"] + "/1/"+all['name'] ;
            document.getElementById('messages-followers').innerHTML+="<a href='" + link +"'>"+
                "<p>"+all.name+"</p></a>";
        }
    </script>
{{--    mesages--}}
    @if(Route::is('mailbox.id'))
    <script>
        let usrId= '{{$MessageModel->getRequestId()}}'
        let showMore = false;
        let messagesDiv = document.getElementById('get-messages');
        let messages = '{{json_encode($messages)}}';
        messages = messages.replace(/&quot;/ig,'"');
        try {
            messages = JSON.parse(messages);
            if(messages.length>{{$MessageModel->getRequest()->page*50-1}}) {
                showMore = true;
            }
            if(messages.length < {{$MessageModel->getRequest()->page*50}}) showMore = false;
        }catch(e){alert(e)}
        let divClass='owner-message';

        if(showMore){
            messagesDiv.innerHTML+=
                "<a href='" + '{{route('mailbox.id', ['id'=>$MessageModel->getRequestId(),'name'=>$MessageModel->getRequest()['name'], 'page'=>$MessageModel->getRequest()->page+1])}}'
                +"'><div class='show-more'>" +
                "Pokaż starsze wiadomości"+
                "</div></a>";
        }

        for (let all of messages){
            let senderId = all.sender_id;
            if(senderId===parseInt(usrId)) divClass='reply-message'
            else divClass='owner-message';
            messagesDiv.innerHTML+=
                "<div class='"+ divClass + "'>" +
                all.body+"<div style='text-align: right; font-size:0.9em;' class='date-of-message'>"+all.created_at+"</div>"
                +"</div>";
        }
        let id = messages[messages.length-1].id;

        function getNewMessage(id, data){
            if(id<data['id']){
                if(data['sender_id']===parseInt(usrId)) divClass='reply-message'
                messagesDiv.innerHTML+=
                    "<div class='"+ divClass + "'>" +
                    data.body+"<div style='text-align: right; font-size:0.9em;' class='date-of-message'>"+"teraz"+"</div>"
                    +"</div>";
                messagesDiv.scroll(0,100000)
            }
            return data['id'];
        }

        var interval = 500;
        function doAjax() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{route('last')}}',
                data: {id: usrId},
                dataType: 'json',
                success: function (data) {
                    id = getNewMessage(id, data)
                    // console.log(data['id'])

                },
                complete: function (data) {
                    // Schedule the next
                    setTimeout(doAjax, interval);
                },
                error: function (error){
                    console.log(error)
                }
            });
        }
        setTimeout(doAjax, interval);
        messagesDiv.scroll(0,100000)
    </script>
                @if(Session::has('message'))

                    <script>
                        let message = '{{Session::get('message')}}';

                        if(message === 'fill'){
                           document.getElementById('body').style.borderColor='red';
                           setTimeout(()=>{
                               document.getElementById('body').style.borderColor='inherit';
                           },2000)
                        }
                    </script>
                @endif


{{--show unseen--}}

    @endif
    <script>


        @foreach(json_decode($MessageModel->showUnSeen()) as $single)
        var link = '{{\Illuminate\Support\Facades\URL::asset('')}}' +'profile/messages/'
            + {{$single}} +"/1/" + '{{$UsrData->getUserDataById($single)[0]['name']}}';
        document.getElementById('new-messages').innerHTML+="<a href='" + link +"'>"+
            "<p>"+'{{$UsrData->getUserDataById($single)[0]['name']}}'+"</p></a>";
        @endforeach





    </script>

    @if(Route::is('mailbox'))
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
                    var link = '{{\Illuminate\Support\Facades\URL::asset('')}}' +'profile/messages/'
                        + data[i]["id"] +"/1/"  + data[i]["name"];
                    document.getElementById('users-list').innerHTML +=
                        "<div class='user-list-user'><a href='"+ link+"'><h1>" +
                        data[i]["name"] + "</h1><br/>"
                        + "<img class='user-list-avatar' src='" + publicDir +data[i]["avatar"] + "' />"

                        +"<br/>#"+data[i]['nick']
                        +"<br/><h3>"+data[i]['loc'] +
                        "</h3></a></div>" ;

                }
                if(e.target.value==="") document.getElementById('users-list').innerHTML ="";
            })

        </script>
    @endif
@endsection
