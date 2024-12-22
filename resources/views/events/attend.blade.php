<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title>Patria Management</title>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('{{ asset('./bg_main.png') }}') no-repeat center bottom;
            background-size: cover;
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
        }

        .main-container { 
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 84px);
        }

        .container {
            text-align: center;
            background: rgba(11, 25, 44, 0.9);
            padding: 0.75rem;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
            color: white;
            margin: 0 10px;
            box-sizing: border-box;
        }

        h1 {
            font-weight: 600;
            font-size: 1.75rem;
            margin: 1rem 0;
        }
        .absensi-text {
            font-weight: 800;
            font-size: 2.5rem;
        }

        #scanner-container {
            margin: 0 auto;
            width: 100%;
            max-width: 170px;
            height: 170px;
            display: flex;
            border: none !important;
            outline: none;
            box-shadow: none;
        }

        #html5-qrcode-button-camera-stop {
            display: none !important;
        }

        input {
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            padding: 0.75rem;
            width: 100%;
            max-width: 300px;
            margin-bottom: 1rem;
            border: none;
            border-radius: 8px;
            box-shadow: inset 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        button {
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            max-width: 300px;
            background: #3a7bd5;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            transition: background 0.3s;
            margin: 10px 0;
        }

        .btnSubmit {
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            display: none;
            max-width: 300px;
            background: #3a7bd5;
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
        
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
                max-width: 90%;
            }

            h1 {
                font-size: 1.75rem;
            }

            input {
                max-width: 100%;
            }

            button, .btnSubmit {
                max-width: 100%;
                padding: 0.75rem 1rem;
            }

            #scanner-container {
                width: 90%;
                height: auto;
                max-width: 250px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.5rem;
            }

            .container {
                max-width: 90%;
            }

            input {
                font-size: 0.9rem;
            }

            button, .btnSubmit {
                font-size: 0.9rem;
                padding: 0.75rem;
            }

            #scanner-container {
                width: 80%;
                height: 250px;
            }
        }
    </style>
</head>
    @include('partials.navbar')
<body>
    <div class="main-container">
        <div class="container">
            <h1 class="absensi-text">ABSENSI</h1>
            <h1>{{ $event->name }}</h1>
            <p>Scan Kode QR atau Tap Kartu Patria anda!</p>

            <button id="permission-button">Request Camera Permission</button>
            <div id="scanner-container"></div>
            <form id="searchForm" method="POST" action="{{ route('attendance.record') }}">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="text" id="userId" name="user_id" placeholder="Enter Patria ID or Card ID" required>
                <button class="btnSubmit" type="submit">Submit Attendance</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("permission-button").addEventListener("click", function () {
            if (!localStorage.getItem("cameraPermissionGranted")) {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then((stream) => {
                        console.log("Camera permission granted!");
                        alert("Camera permission granted. You can now start scanning.");
                        
                        localStorage.setItem("cameraPermissionGranted", "true");

                        // Stop the stream after permission check
                        stream.getTracks().forEach((track) => track.stop());

                        // Display scanner and hide the button
                        document.getElementById("scanner-container").style.display = "block";
                        document.getElementById("permission-button").style.display = "none";

                        // Initialize QR Code Scanner
                        const html5QrcodeScanner = new Html5QrcodeScanner(
                            "scanner-container", { fps: 10, qrbox: 250 }, false
                        );

                        html5QrcodeScanner.render(onScanSuccess);

                        const stopButton = document.querySelector(".html5-qrcode-button-stop");
                        if (stopButton) {
                            stopButton.parentElement.removeChild(stopButton);
                        }
                    })
                    .catch((err) => {
                        console.error("Camera permission error:", err);
                        alert("Camera permission denied. Please enable camera access in your browser settings.");
                    });
            } else {
                document.getElementById("scanner-container").style.display = "block";
                document.getElementById("permission-button").style.display = "none";

                // Initialize QR Code Scanner
                const html5QrcodeScanner = new Html5QrcodeScanner(
                    "scanner-container", { fps: 10, qrbox: 250 }, false
                );

                html5QrcodeScanner.render(onScanSuccess);

                // Remove the stop scanning button after rendering
                const stopButton = document.querySelector(".html5-qrcode-button-stop");
                if (stopButton) {
                    stopButton.parentElement.removeChild(stopButton);
                }
            }
        });

        let lastOpenedTime = 0;

        function onScanSuccess(qrCodeMessage) {
            const currentTime = new Date().getTime();

            if (currentTime - lastOpenedTime >= 500) {
                console.log("Scanned QR Code:", qrCodeMessage);

                const urlParts = qrCodeMessage.split("/");
                const userId = urlParts[urlParts.length - 1];

                const userIdInput = document.getElementById("userId");
                userIdInput.value = userId;

                const form = document.getElementById("searchForm");
                form.submit();

                lastOpenedTime = currentTime;
            } else {
                console.log("Window opening too soon. Please wait 0.5 seconds.");
            }
        }

    </script>


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
