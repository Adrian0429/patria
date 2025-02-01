<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-align: center;
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        label {
            font-weight: 600;
            margin-top: 1rem;
            display: block;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        button {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            border: none;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        #logo-preview {
            margin: 1rem auto;
            max-width: 100%;
            max-height: 200px;
            display: none;
        }
    </style>
</head>
<body>
    <h1>Create Event</h1>
    <form action="{{ route('events.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name">Event Name:</label>
        <input type="text" name="name" id="name" placeholder="Enter Event Name" required>

        {{-- <label for="logo">Event Logo:</label>
        <input type="file" name="logo" id="logo" accept="image/*" onchange="previewLogo(event)">
        <img id="logo-preview" src="#" alt="Logo Preview"> --}}

        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" required>

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" required>

        <button type="submit">Save Event</button>
    </form>

    <script>
        function previewLogo(event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('logo-preview');
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        }
    </script>
</body>
</html>
