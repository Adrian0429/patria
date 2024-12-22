<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patria</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
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

    @if (session('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                backgroundColor: "#28a745",
                duration: 3000,
                close: true,
                gravity: "top", 
                position: "right",
                stopOnFocus: true 
            }).showToast();
        </script>
    @endif
</body>
</html>
