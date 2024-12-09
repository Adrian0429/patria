    <style>
        .login-container {
            display: flex;
            height: calc(100vh - 58px);
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .login-card{
            text-align: center;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 18px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
        }

        h1 {
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 2rem;
        }

        input {
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            padding: 0.75rem;
            width: 100%;
            max-width: 300px;
            margin-bottom: 1rem;
            border: 2px solid #0A3981;
            border-radius: 8px;

        }

        button {
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            background: #3a7bd5;
            width: 100%;
            max-width: 300px;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            transition: background 0.3s;
            margin: 10px 0;
        }

        button:hover {
            background: #2a6bb5;
        }
        form { 
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>


@extends('layouts.app')
@section('content')
    <div class="login-container">
        <div class="login-card">
            <h1>Admin Login</h1>
        <p>Sign in to manage your dashboard</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        </div>
        
        @if (session('error'))
            <script>
                Toastify({
                    text: "{{ session('error') }}",
                    backgroundColor: "#ff5f6d",
                    duration: 3000,
                    close: true,
                    gravity: "top", 
                    position: "right",
                    stopOnFocus: true 
                }).showToast();
            </script>
        @endif
    </div>
@endsection

