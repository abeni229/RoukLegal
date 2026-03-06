@extends('layouts.app')
@section('title', 'Conversation avec ' . $user->nom)
@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="fw-bold">Conversation avec {{ $user->nom }}</h2>
        @php
            $home = Auth::user() && Auth::user()->role === 'acteur_juridique' ? route('acteur.dashboard') : route('client.dashboard');
        @endphp
        <a href="{{ $home }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Retour au tableau de bord
        </a>
    </div>
    <div class="col-12">
        <p class="text-muted">Échange privé sur la plateforme</p>
    </div>
</div>

<div class="card">
    <div class="card-body" style="max-height: 60vh; overflow-y: auto;">
        @foreach($messages as $msg)
            @php
                $isMe = $msg->sender_id === Auth::id();
                if($msg->sender->profile_photo) {
                    $avatar = asset('storage/'.$msg->sender->profile_photo);
                } elseif($msg->sender->photo_professionnelle) {
                    $avatar = asset('storage/'.$msg->sender->photo_professionnelle);
                } else {
                    $avatar = 'https://via.placeholder.com/40';
                }
            @endphp
            <div class="d-flex mb-3 {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}">
                @if(!$isMe)
                    <img src="{{ $avatar }}" class="rounded-circle me-2" style="width:40px; height:40px; object-fit:cover;">
                @endif
                <div class="bubble {{ $isMe ? 'bubble-right bg-primary text-white' : 'bubble-left bg-light' }}">
                    {{ $msg->message }}
                    <div class="text-end mt-1" style="font-size:0.75rem; opacity:0.6;">
                        {{ $msg->created_at->format('H:i') }}
                    </div>
                </div>
                @if($isMe)
                    @php
                        $meAvatar = Auth::user()->profile_photo ? asset('storage/'.Auth::user()->profile_photo) : (Auth::user()->photo_professionnelle ? asset('storage/'.Auth::user()->photo_professionnelle) : 'https://via.placeholder.com/40');
                    @endphp
                    <img src="{{ $meAvatar }}" class="rounded-circle ms-2" style="width:40px; height:40px; object-fit:cover;">
                @endif
            </div>
        @endforeach
    </div>
</div>
<style>
    .bubble {
        max-width: 70%;
        padding: 0.75rem 1rem;
        border-radius: 1rem;
        position: relative;
    }
    .bubble-left {
        border-top-left-radius: 0;
    }
    .bubble-right {
        border-top-right-radius: 0;
    }
</style>

<form method="POST" action="{{ route('messages.send', ['user' => $user->id]) }}" class="mt-3">
    @csrf
    <div class="input-group">
        <textarea name="message" class="form-control" rows="2" placeholder="Écrire un message..."></textarea>
        <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i> Envoyer</button>
    </div>
    @error('message')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</form>
@endsection