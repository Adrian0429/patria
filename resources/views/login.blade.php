<style>
/* General Styling for the Login Container */
.login-container {
    display: flex;
    background: url('{{ asset('./bg_polos.PNG') }}') no-repeat center center;
    background-size: cover;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.login-card {
    background: rgba(255, 255, 255, 0.1); /* Glassmorphism background */
    backdrop-filter: blur(10px); /* Glass effect */
    padding: 2.5rem;
    border-radius: 15px;
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
    text-align: center;
    border: 2px solid rgba(255, 255, 255, 0.2); /* Subtle border */
}

/* Heading Styling */
h1 {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 2.5rem;
    color: #fff;
    margin-bottom: 0.7rem;
    text-transform: uppercase;
}

/* Paragraph text below the heading */
p {
    font-family: 'Poppins', sans-serif;
    font-size: 1rem;
    color: #d1d1d1;
    margin-bottom: 1.5rem;
}

/* Form Input Fields */
input {
    font-family: 'Poppins', sans-serif;
    font-size: 1rem;
    padding: 0.75rem;
    width: 100%;
    max-width: 320px;
    margin-bottom: 1.5rem;
    border: 2px solid #0A3981;
    border-radius: 8px;
    outline: none;
    transition: all 0.3s ease;
}

/* Input Focus Effects */
input:focus {
    border-color: #3a7bd5;
    box-shadow: 0 0 10px rgba(58, 123, 213, 0.5);
}

/* Button Styling */
button {
    font-family: 'Poppins', sans-serif;
    font-size: 1rem;
    font-weight: 600;
    background: linear-gradient(135deg, #3a7bd5, #2a5298); /* Gradient button */
    width: 100%;
    max-width: 320px;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    cursor: pointer;
    transition: background 0.3s, transform 0.3s;
}

/* Button Hover Effects */
button:hover {
    background: linear-gradient(135deg, #2a5298, #1e3c72);
    transform: translateY(-4px);
}

/* Button Focus Effect */
button:focus {
    outline: none;
    box-shadow: 0 0 10px rgba(58, 123, 213, 0.7);
}

/* Flex Container for Form */
form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Small Responsiveness Improvements */
@media (max-width: 480px) {
    .login-card {
        padding: 2rem;
        max-width: 90%;
    }

    h1 {
        font-size: 2rem;
    }

    input, button {
        max-width: 100%;
    }
}

</style>


@extends('layouts.app')
@section('content')
    <div class="login-container">
        <div class="login-card">
        <h1>Login Akun Patria</h1>
        <p>Gunakan Email dan Password Anda</p>

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

