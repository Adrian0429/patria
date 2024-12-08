<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>User Management</title>
    <style>
        body {
            background-color: #f7faff;
            font-family: 'Inter', sans-serif;
        }

        .container {
            margin-top: 2rem;
        }

        h1 {
            color: #3a7bd5;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: #3a7bd5;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2a6bb5;
        }

        .table {
            background: white;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .add-user-btn {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">User Management</h1>
        
        <div class="add-user-btn">
            <a href="{{ route('users.create') }}" class="btn btn-primary">Add New User</a>
        </div>

        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Card ID</th>
                    <th>User ID</th>
                    <th>Nama Lengkap</th>
                    <th>Jenis Kelamin</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->card_id }}</td>
                    <td>{{ $user->user_id }}</td>
                    <td>{{ $user->nama_lengkap }}</td>
                    <td>{{ $user->jenis_kelamin }}</td>
                    <td>
                        <a href="{{ route('users.show', $user->user_id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('users.destroy', $user->user_id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
