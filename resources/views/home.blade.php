@extends('layouts.app')
@inject('Party', 'App\Http\Controllers\PartyController')

@section('content')
    <link rel="stylesheet" href="{{ URL::asset('css/layout.css') }}">
  <div class="content" style="
      background: url('{{\Illuminate\Support\Facades\URL::asset('images')."/banner.jpg"}}');
      background-size: contain; background-repeat: no-repeat; padding:30px;
      ">


    <div class="ein-row">
        <h3>Ostatnio dodane</h3>
        @foreach($Party->get5Parties() as $single)
            <div class="home-single-xx-div">
            <a href="{{\Illuminate\Support\Facades\URL::asset('')."partybox/".$single->id."/".$single->title}}">
            <img class="home-single-party-image-src" src="{{\Illuminate\Support\Facades\URL::asset('').$single->image}}">
           <br/>
                <label style="vertical-align: middle" class="home-single-party" style="margin-block:10px;">
               <label  class="home-single-party-title">
                  <h3> {{ $single->title}}</h3>
               </label><br/>
               <label class="home-single-party-why">
                   {{ $single->why}}
               </label>
           </label>
            </a>
    </div>
        @endforeach
    </div>

      <div class="zwei-row">
          Ostatnio w województwie  <select name="region">
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
      </div>

      <div class="drei-row">
          Wpisz nazwę miasta, aby wyszukać imprezy
      </div>


  </div>


<script>

</script>
@endsection
