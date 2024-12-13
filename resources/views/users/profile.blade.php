@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Profile</h1>
    <div class="card mb-4">
        <div class="card-body">
            @if($user->image_link)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $user->image_link) }}" alt="{{ $user->nama_lengkap }}" class="img-thumbnail" style="width: 150px; height: 150px;">
                </div>
            @endif
            <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-primary">Edit Profile</a>

            <h3>{{ $user->nama_lengkap }}</h3>
            <p><strong>User ID:</strong> {{ $user->user_id }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Jenis Kelamin:</strong> {{ $user->jenis_kelamin }}</p>
            <p><strong>Tanggal Lahir:</strong> {{ $user->tanggal_lahir }}</p>
            <p><strong>Golongan Darah:</strong> {{ $user->golongan_darah }}</p>
            <p><strong>Vihara:</strong> {{ $user->vihara }}</p>
            <p><strong>Role:</strong> {{ $user->role }}</p>
        </div>
    </div>
</div>
@endsection
