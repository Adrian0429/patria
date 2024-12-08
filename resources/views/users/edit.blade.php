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
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('users.update', $user->user_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $user->nama_lengkap }}">
        </div>
        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                <option value="Laki-laki" {{ $user->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}">
        </div>
        <div class="mb-3">
            <label for="golongan_darah" class="form-label">Golongan Darah</label>
            <input type="text" class="form-control" id="golongan_darah" name="golongan_darah" value="{{ $user->golongan_darah }}">
        </div>
        <div class="mb-3">
            <label for="vihara" class="form-label">Vihara</label>
            <input type="text" class="form-control" id="vihara" name="vihara" value="{{ $user->vihara }}">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Profile Image</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($user->image_link)
                <p>Current Image:</p>
                <img src="{{ asset('storage/' . $user->image_link) }}" alt="Profile Image" width="150">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

