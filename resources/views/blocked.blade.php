@extends('layouts.app')
@section('content')
    @inject('Blocker', 'App\Http\Controllers\BlockController')
    <div class="empty-invites">
        <h1>Zostałeś zablokowany przez tego użytkownika 🛑</h1>
        <button class="header-profile-button" onclick="history.back()">wróć</button>
    </div>

@endsection
