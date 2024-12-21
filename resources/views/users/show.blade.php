<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patria</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: url('{{ asset('./bg_main.png') }}') no-repeat center bottom;
            background-size: cover;
            color: white;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: rgba(11, 25, 44, 0.8);
            border-radius: 16px;
            padding: 2rem 0;
            max-width: 55%;
            width: 100%;
            height: 50vh;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 1.5rem;
        }

        .user-picture-container {
            flex: 1;
            justify-content: center;
            align-content: center;
            min-width: 25%;
            max-width: 60%;
            height: 100%;
            position: relative; 
            border-radius: 12px;
            margin: 0 1.5rem;
        }

        .user-picture {
            width: auto;
            height: 100%;
            background-size: contain; 
            background-repeat: no-repeat;
            background-position: center;
            border-radius: 12px;
        }

        .info {
            flex: 2;
            text-align: start;
        }

        .info h1 {
            font-size: 2.3rem;
            font-weight: 800;
        }

        .info p {
            margin: 0.25rem 0;
            font-size: 1rem;
        }

        .btn {
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            background: #133E87;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 1rem;
            display: inline-block;
        }

        .btn:hover {
            background: #2a6bb5;
        }

        /* Media query for smaller desktop screens */
        @media (max-width: 1200px) {
            .container {
                max-width: 70%;
                height: auto;
                flex-direction: column;
                padding: 2rem;
            }

            .user-picture-container {
                max-width: 80%;
                height: auto;
                margin: 0 0.25rem;
            }

            .info h1 {
                font-size: 2rem;
            }

            .info p {
                font-size: 1rem;
            }

            .btn {
                font-size: 0.9rem;
                padding: 0.6rem 1.2rem;
            }
        }

        /* Media query for extra-small desktop screens */
        @media (max-width: 768px) {
            .container {
                max-width: 60%;
                height: auto;
            }

            .info h1 {
                font-size: 1.8rem;
            }

            .info p {
                font-size: 0.9rem;
            }

            .btn {
                font-size: 0.85rem;
                padding: 0.5rem 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="user-picture-container">
            @if($user->image_link)
            <img class="user-picture" src="{{ asset('storage/' . $user->image_link) }}"/>
            @endif
        </div>

        <div class="info">
            <div>
            <h1><strong>Hai, saya <br> {{ $user->nama_lengkap }} !</strong></h1>
            <p><strong>Email: </strong>{{ $user->email }}</p>
            <p><strong>Jenis Kelamin:</strong> {{ $user->jenis_kelamin }}</p>
            <p><strong>Tanggal Lahir:</strong> {{ $user->tanggal_lahir }}</p>
            <p><strong>Golongan Darah:</strong> {{ $user->golongan_darah }}</p>
            <p><strong>Vihara:</strong> {{ $user->vihara }}</p>
            </div>

            <div>
                @if (Auth::check() && Auth::user()->user_id == $user->user_id)
                <a href="{{ route('users.edit', $user->user_id) }}" class="btn" style="margin-right: 8px;">Edit Profile</a>
                @endif
                <a href="/" class="btn">Kembali</a>  
                
            </div>
            
        </div>
    </div>
</body>
</html>
