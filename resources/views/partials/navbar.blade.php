<style>
    /* Navbar Styles */
        .navbar {
            display: flex;
            height: 64px;
            justify-content: space-between;
            align-items: center;
            background: rgba(11, 25, 44, 0.9);
            color: white;
            padding: 10px 20px;
        }
        .navbar .logo {
            font-weight: 600;
            font-size: 1.5rem;
        }

        .navbar .links {
            display: flex;
            gap: 15px;
        }

        .navbar .links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        .navbar .links a:hover {
            color: #3a7bd5;
        }

        .navbar .login a {
            color: white;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
        }
        .username {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
        }

        .links { 
            display: flex;
            gap: 24px;
            align-items: center;
            justify-content: center;
        }

        .links a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .nav-logo { 
            width: 64px;
            height: 64px;
            margin: 0px 10px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
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
            top: 100%; /* Position below the button */
            left: 0;
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
            display: block; /* Show the menu when the dropdown is hovered */
        }

        .button-logout{
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
</style>
<nav class="navbar">
        <div>
                <div class="links">
                    <img class="nav-logo" src="./patria.png" alt="">
                    <a style="font-size: 1.2rem;" href="/">Home</a>
                    @if (Auth::check())
                        <a style="font-size: 1.2rem;"  href="/users">Dashboard</a>
                    @endif
                    
                </div>
        </div>
            @if (Auth::check())
            <div class="dropdown">
                <button class="dropdown-button">{{ Auth::User()->nama_lengkap }}</button>
                <div class="dropdown-menu">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="button-logout" type="submit">Logout</button>
                    </form>
                </div>
            </div>
                @else 
                <div class="login">
                    {{-- <p>{{ Auth::User()->nama_lengkap }}</p> --}}
                    <a href="{{ route('login') }}">Login</a>
                </div>
            @endif
</nav>