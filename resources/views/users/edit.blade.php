<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
            font-family: 'Inter', sans-serif;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #0d6efd; /* Bootstrap primary color */
            border: none;
        }
        .btn-primary:hover {
            background-color: #0a58ca;
        }
        .toastify {
            font-size: 0.9rem;
        }

.btn-add-user {
    display: inline-block;
    padding: 10px 20px;
    font-size: 1rem;
    font-weight: bold;
    text-align: center;
    color: #fff;
    background-color: #007bff;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.3s, transform 0.3s;
    max-width: 300px;
    margin-bottom: 20px;
}

.btn-add-user:hover {
    background-color: #0056b3;
    transform: translateY(-2px); /* Slight lift effect on hover */
}

.btn-add-user:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.5); /* Focus ring */
}
</style>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary font-bold">Edit Anggota: <strong>{{ $user->nama_lengkap }}</strong></h1>

        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'DPP')
        <a href="{{ route('users.home') }}" class="btn-add-user">Daftar Anggota</a>
        @else
        <a href="{{ route('home') }}" class="btn-add-user">Kembali</a>  
        @endif

        <div class="card p-4">
            <form action="{{ route('users.update', $user->user_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @if (Auth::user()->role == 'admin')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="card_id" class="form-label">Card ID</label>
                        <input type="text" class="form-control" id="card_id" name="card_id" value="{{ $user->card_id }}">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="user_id" class="form-label">User ID</label>
                        <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $user->user_id }}">
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $user->nama_lengkap }}">
                    </div>
                   
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password">
                    </div>
                
                    <div class="col-md-6 mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                            <option value="Laki-laki" {{ $user->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="golongan_darah" class="form-label">Golongan Darah</label>
                        <select class="form-select" id="golongan_darah" name="golongan_darah">
                            <option value="" disabled>Golongan Darah</option>
                            <option value="O" {{ $user->golongan_darah == 'O' ? 'selected' : '' }}>O</option>
                            <option value="A" {{ $user->golongan_darah == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ $user->golongan_darah == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ $user->golongan_darah == 'AB' ? 'selected' : '' }}>AB</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'DPC')
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Jabatan</label>
                        <select class="form-select" id="role" name="role">
                            <option value="" disabled>Select Role</option>
                            <option value="DPP" {{ $user->role == 'DPP' ? 'selected' : '' }}>DPP</option>
                            <option value="DPD" {{ $user->role == 'DPD' ? 'selected' : '' }}>DPD</option>
                            <option value="DPC" {{ $user->role == 'DPC' ? 'selected' : '' }}>DPC</option>
                            <option value="DPAC" {{ $user->role == 'DPAC' ? 'selected' : '' }}>DPAC</option>
                            <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>Anggota</option>
                        </select>
                    </div>
                    @endif

                    <div class="col-md-6 mb-3">
                        <label for="vihara" class="form-label">Vihara</label>
                        <input type="text" class="form-control" id="vihara" name="vihara" value="{{ $user->vihara }}">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="daerah" class="form-label">Daerah</label>
                    <select class="form-select" id="daerah" name="daerah" required>
                        <option value="" disabled selected>Pilih Daerah</option>
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="image" class="form-label">Profile Image</label>
                    <input 
                        type="file" 
                        class="form-control" 
                        id="image" 
                        name="image" 
                        accept="image/*" 
                        onchange="previewImage(event)">
                    
                    @if($user->image_link)
                        <p class="mt-3">Current Image:</p>
                        <img id="imagePreview" class="rounded-2" src="{{ asset('storage/' . $user->image_link) }}" alt="Profile Image" width="150">
                    @endif
                </div>

                <button type="submit" class="btn btn-primary w-100">Save</button>
            </form>
        </div>
    </div>
    <!-- Toastify Script -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    Toastify({
                        text: "{{ $error }}",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#ff6b6b",
                    }).showToast();
                @endforeach
            @endif
        });

        function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result; // Set the preview image source
                preview.style.display = 'block'; // Show the preview image
            };
            
            reader.readAsDataURL(input.files[0]); // Read the file as a data URL
        }
    }

    </script>
</body>
</html>

