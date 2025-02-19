<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
    }

    a {
        text-decoration: none;
        color: white;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 64px;
        background: rgba(11, 25, 44);
        color: white;
        padding: 10px 16px;
        position: relative;
        z-index: 1000;
    }

    .login a { 
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        color: white;
    }
    
    .navbar .left {
        display: flex;  
        gap: 24px;
        font-weight: 600;
        font-size: 1rem;
        align-items: center;
    }

    .navbar .logo {
        font-weight: 600;
        font-size: 1.5rem;
    }

    .nav-logo {
        height: 60px;
        width: auto;
    }

    .navbar .links {
        display: flex;
        gap: 24px;
        align-items: center;
    }

    .navbar .links a {
        color: white;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: color 0.3s ease;
    }

    .navbar .links a:hover {
        color: #3a7bd5;
    }

    .dropdown-button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

    .dropdown {
        position: relative;
        display: inline-block;
    }
            @media (max-width: 768px) {
                .dropdown {
                        display: none;
                }
                .login {
                        display: none;
                }
        }    

        .dropdown-button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dropdown-button:hover {
            background-color: #0056b3;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%; 
            right: 0;
            padding: 1rem;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            overflow: hidden;
            z-index: 1000;
            min-width: 160px;
        }

        .dropdown-menu .dropdown-item {
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            display: block;
            transition: background-color 0.2s ease;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-menu {
            display: block; 
        }

        .button-logout{
            margin-top: 12px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            padding: 10px 64px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .button-profile{
            width: 100%;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            padding: 10px 64px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

    .hamburger {
        display: none;
        flex-direction: column;
        gap: 5px;
        cursor: pointer;
    }

    .hamburger div {
        width: 25px;
        height: 3px;
        background: white;
    }

    .mobile-menu {
        display: none;
        flex-direction: column;
        gap: 10px;
        position: absolute;
        top: 64px;
        left: 0;
        width: 100%;
        background: rgba(11, 25, 44);
        padding: 10px 16px;
        z-index: 999;
    }

    .mobile-menu a {
        color: white;
        text-decoration: none;
        font-weight: 600;
        padding: 10px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .mobile-menu a:last-child {
        border-bottom: none;
    }

    @media (max-width: 768px) {
        .links {
            display: none;
        }

        .hamburger {
            display: flex;
        }
    }
</style>

<nav class="navbar">
    <div class="left">
        <div class="logo-section">
            <img class="nav-logo" src="./logo_putih.png" alt="Logo">
        </div>

        <div class="links">
            <a href="/">Show</a>
            @if (Auth::check())
            <a href="/anggota">Anggota</a>
            <a href="/events">Event</a>
            @endif
            @if (Auth::check() && Auth::User()->jabatan == 'admin')
                <a href="/users">Akun</a>
                <a href="/dpd">List DPD</a>
                <a href="/dpc">List DPC</a>
            @endif

        </div>
    </div>


    @if (Auth::check())
        <div class="dropdown">
            <button class="dropdown-button">{{ Auth::user()->nama }}</button>
            <div class="dropdown-menu">
                <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="button-logout" type="submit">Logout</button>
                </form>
            </div>
        </div>
    @else
        <div class="login">
            <a href="{{ route('login') }}">Login</a>
        </div>
    @endif

    <div class="hamburger" onclick="toggleMobileMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div class="mobile-menu" id="mobileMenu">
        <a href="/">Home</a>
        @if (Auth::check() && Auth::User()->role != 'Anggota')
                <a href="/users">Akun</a>
                <a href="/anggota">Anggota</a>
                <a href="/dpd">List DPD</a>
                <a href="/dpc">List DPC</a>
                <a href="/events">Event</a>
        @endif
        @if (Auth::check())
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: white;">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
        @endif
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        mobileMenu.style.display = mobileMenu.style.display === 'flex' ? 'none' : 'flex';
    }
</script>
