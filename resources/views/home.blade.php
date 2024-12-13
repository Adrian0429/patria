<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <title>Patria Management</title>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('{{ asset('./bg_polos.PNG') }}') no-repeat center bottom;
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
            padding: 1rem;
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
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }

        #scanner-container {
            margin: 0 auto;
            width: 100%;
            max-width: 200px;
            height: 200px;
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

        /* Responsive Styles */
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
<body>
    @include('partials.navbar')
    <div class="main-container">
        <div class="container">
            <h1>Selamat Datang Patria!</h1>
            <p>Scan Kode QR atau Tap Kartu Patria anda!</p>

            <button id="permission-button">Request Camera Permission</button>

            <div id="scanner-container"></div>

            <form id="searchForm" method="GET">
                <input type="text" id="userId" name="userId" placeholder="Enter Patria ID or Card ID" required>
                <button class="btnSubmit" type="submit">Search</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("permission-button").addEventListener("click", function () {
            // Check if camera permission has already been granted
            if (!localStorage.getItem("cameraPermissionGranted")) {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then((stream) => {
                        console.log("Camera permission granted!");
                        alert("Camera permission granted. You can now start scanning.");
                        
                        // Save the camera permission state in localStorage
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

                        // Remove the stop scanning button after rendering
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
                // If permission is already granted, just show the scanner
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

        let lastOpenedTime = 0; // Store the last time the window was opened

        function onScanSuccess(qrCodeMessage) {
            const currentTime = new Date().getTime();
            
            // Only open a new window if 500ms have passed since the last one
            if (currentTime - lastOpenedTime >= 500) {
                console.log("Scanned QR Code:", qrCodeMessage);
                var url = '/users/' + qrCodeMessage;
                window.open(url, '_blank');
                
                // Update the last opened time to the current time
                lastOpenedTime = currentTime;
            } else {
                console.log("Window opening too soon. Please wait 0.5 seconds.");
            }
        }

        document.getElementById('searchForm').addEventListener('submit', function (event) {
            event.preventDefault();  // Prevent the default form submission

            var userId = document.getElementById('userId').value;

            var url = '/users/' + userId;

            window.open(url, '_blank');
        });
    </script>

</body>
</html>
