
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
            position: relative;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 84px);
        }

        .header-logo{
                position: absolute;
                display: flex;
                flex-direction: row;
                align-items: center;
                top: 0;
                left: 0;
                margin-left: 5rem;
                margin-top: 2rem;
        }

        @media (max-width: 768px) {
                .header-logo {
                        display: none;
                }
        }     
        
        .logo-patria { 
                        width: 6rem;
                        height: auto;
                    }

        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;700;800&display=swap');

        .header-text { 
            margin-left: 1rem;
            color: white;
            font-size: 1.5rem;
            font-family: 'Montserrat', sans-serif;
        }

        .header-text .top {
            font-weight: 200; /* Light weight */
        }

        .header-text .bottom {
            font-weight: 700; /* Extra-bold weight */
        }
        
        .container {
            text-align: center;
            background: rgba(11, 25, 44, 0.9);
            padding: 1.55rem 1rem;
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
            margin: 20px auto;
            width: 100%;
            max-width: 100px;
            height: 20px;
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
                height: 20px;
                max-width: 100px;
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
@extends('layouts.app')
@section('content')
    <div class="main-container">
        <div class="header-logo">
            <img src="./logo_putih.png" alt="" class="logo-patria">
            <div class="header-text">
                <p class="top">DATA ANGGOTA</p>
                <p class="bottom">PEMUDA THERAVĀDA INDONESIA</p>
            </div>
        </div>
        
        <div class="container">
            <h1>Selamat Datang Patria!</h1>
            <p>Scan Kode QR atau Tap Kartu Patria anda!</p>

            <button id="permission-button">Request Camera Permission</button>

            <div id="scanner-container"></div>
            <button id="switch-camera-button" style="display:none;">Switch Camera</button>

            <form id="searchForm" method="GET">
                <input type="text" id="userId" name="userId" placeholder="Enter Patria ID or Card ID" required>
                <button class="btnSubmit" type="submit">Search</button>
            </form>
        </div>
    </div>


    <script>
        let currentFacingMode = "environment"; // Default to rear camera
        let html5QrcodeScanner;

        // Request camera permission and initialize the scanner
        document.getElementById("permission-button").addEventListener("click", function () {
            if (!localStorage.getItem("cameraPermissionGranted")) {
                navigator.mediaDevices.getUserMedia({ video: { facingMode: currentFacingMode } })
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
                        html5QrcodeScanner = new Html5QrcodeScanner("scanner-container", { fps: 10, qrbox: 250 }, false);
                        html5QrcodeScanner.render(onScanSuccess);

                        // Remove the stop scanning button after rendering
                        const stopButton = document.querySelector(".html5-qrcode-button-stop");
                        if (stopButton) {
                            stopButton.parentElement.removeChild(stopButton);
                        }

                        // Show the camera switch button
                        document.getElementById("switch-camera-button").style.display = "block";
                    })
                    .catch((err) => {
                        console.error("Camera permission error:", err);
                        alert("Camera permission denied. Please enable camera access in your browser settings.");
                    });
            } else {
                // If permission is already granted
                document.getElementById("scanner-container").style.display = "block";
                document.getElementById("permission-button").style.display = "none";

                // Initialize QR Code Scanner
                html5QrcodeScanner = new Html5QrcodeScanner("scanner-container", { fps: 10, qrbox: 250 }, false);
                html5QrcodeScanner.render(onScanSuccess);

                // Remove the stop scanning button after rendering
                const stopButton = document.querySelector(".html5-qrcode-button-stop");
                if (stopButton) {
                    stopButton.parentElement.removeChild(stopButton);
                }

                // Show the camera switch button
                document.getElementById("switch-camera-button").style.display = "block";
            }
        });

        // Switch camera functionality
        document.getElementById("switch-camera-button").addEventListener("click", function () {
            // Stop the current camera stream
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }

            // Toggle between user (front) and environment (rear) cameras
            currentFacingMode = (currentFacingMode === "environment") ? "user" : "environment";

            // Reinitialize the scanner with the new camera
            navigator.mediaDevices.getUserMedia({ video: { facingMode: currentFacingMode } })
                .then((stream) => {
                    console.log(`Switched to ${currentFacingMode} camera.`);
                    
                    // Reinitialize QR scanner with the new camera
                    html5QrcodeScanner = new Html5QrcodeScanner("scanner-container", { fps: 10, qrbox: 250 }, false);
                    html5QrcodeScanner.render(onScanSuccess);

                    // Remove the stop scanning button after rendering
                    const stopButton = document.querySelector(".html5-qrcode-button-stop");
                    if (stopButton) {
                        stopButton.parentElement.removeChild(stopButton);
                    }
                })
                .catch((err) => {
                    console.error("Error switching camera:", err);
                    alert("Unable to switch camera. Please try again.");
                });
        });

        let lastOpenedTime = 0;

        function onScanSuccess(qrCodeMessage) {
            const currentTime = new Date().getTime();

            if (currentTime - lastOpenedTime >= 500) {
                console.log("Scanned QR Code:", qrCodeMessage);
                window.open(qrCodeMessage, '_blank');

                lastOpenedTime = currentTime;
            } else {
                console.log("Window opening too soon. Please wait 0.5 seconds.");
            }
        }


        document.getElementById('searchForm').addEventListener('submit', function (event) {
            event.preventDefault(); 

            var userId = document.getElementById('userId').value;

            var url = '/users/' + userId;

            window.open(url, '_blank');
        });
    </script>

@endsection
