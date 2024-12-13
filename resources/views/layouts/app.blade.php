<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patria</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Toastify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <style>

        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            width: 100vw;
        }
        
    </style>
</head>
        @include('partials.navbar')
<body>

        @yield('content')
        
</body>
</html>
