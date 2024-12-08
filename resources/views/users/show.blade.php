<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title>User Details</title>

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #3a7bd5;
            color: white;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: rgba(0, 0, 0, 0.6);
            border-radius: 16px;
            padding: 1.5rem;
            max-width: 60%;
            width: 100%;
            height: 70vh;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
        
        .user-picture-container {
            width: 45%;
            height: 100%;
            border-radius: 12px;
        }

        .user-picture {
            position: relative;
            width: 100%;
            height: 100%;
            background-size: cover; 
            background-repeat: no-repeat;
            background-position: center;
            border-radius: 12px;
        }

        .info {
            width: 50%;
            text-align: start;
        }

        .info h1 {
            font-size: 2.75rem;
            font-weight: 800;
        }

        .info p {
            margin: 0.25rem 0;
            font-size: 1.25rem;
        }

        .btn {
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            background: #3a7bd5;
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
    </style>
</head>
<body>
    <div class="container">
        @if($user->image_link)
        <div class="user-picture-container">
            <div class="user-picture" style="background-image: url('{{ asset('storage/' . $user->image_link) }}');"></div>
        </div>
            
        @endif
        <div class="info">
            <h1>
                <strong>
                    Hai, saya <br> {{ $user->nama_lengkap }} !
                </strong>
            </h1>
            <p><strong>Jenis Kelamin:</strong> {{ $user->jenis_kelamin }}</p>
            <p><strong>Tanggal Lahir:</strong> {{ $user->tanggal_lahir }}</p>
            <p><strong>Golongan Darah:</strong> {{ $user->golongan_darah }}</p>
            <p><strong>Vihara:</strong> {{ $user->vihara }}</p>
            <a href="/" class="btn">Back</a>
        </div>
        
    </div>
</body>
</html>
