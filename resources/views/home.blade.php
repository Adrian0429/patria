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
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #3a7bd5;
            color: white;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            text-align: center;
            background: rgba(0, 0, 0, 0.55);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;

        }

        h1 {
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }

        p {
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        #scanner-container {
            margin: 0 auto;
            width: 300px;
            height: 300px;
            display: flex;
            border: none !important;
            outline: none; /* Remove focus outline if any */
            box-shadow: none; /* Remove shadow effects, if any */
            
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang Patria !</h1>
        <p>Scan Kode QR atau Tap Kartu Patria anda !</p>

        <button id="permission-button">Request Camera Permission</button>

        <div id="scanner-container"></div>

        <form id="searchForm" method="GET">
            <input type="number" id="userId" name="userId" placeholder="Enter Patria ID or Card ID" required>
            <button type="submit">Search</button>
        </form>

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

                        // Fully remove the stop scanning button after rendering
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

                // Fully remove the stop scanning button after rendering
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



    </script>


    <script>
        document.getElementById('searchForm').addEventListener('submit', function (event) {
            event.preventDefault();  // Prevent the default form submission

            var userId = document.getElementById('userId').value;

            var url = '/users/' + userId;

            window.open(url, '_blank');
        });
    </script>
</body>
</html>
