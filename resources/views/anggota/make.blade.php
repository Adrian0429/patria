<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Toastify CSS -->
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

        .button-row{
            display: flex;
            justify-content: space-between;
        }
/* Typography Styles */
body {
    font-family: 'Inter', sans-serif;
    color: #333;
    line-height: 1.6;
}

/* Headings */
h1, h2, h3, h4, h5, h6 {
    font-weight: 600;
    color: #0d6efd;
}

h1 {
    font-size: 2rem;
}

h2 {
    font-size: 1.75rem;
}

h3 {
    font-size: 1.5rem;
}

h4 {
    font-size: 1.25rem;
}

h5 {
    font-size: 1.1rem;
}

h6 {
    font-size: 1rem;
}

/* Labels */
label {
    font-weight: 600;
    font-size: 0.95rem;
    color: #555;
}

/* Inputs & Selects */
input, select, textarea {
    font-size: 1rem;
    color: #222;
}

input::placeholder, textarea::placeholder {
    color: #aaa;
    font-style: italic;
}

/* Buttons */
button, .btn {
    font-size: 1rem;
    font-weight: bold;
}

/* Links */
a {
    font-weight: 600;
    color: #007bff;
    text-decoration: none;
}

a:hover {
    color: #0056b3;
    text-decoration: underline;
}

/* Small Text */
small {
    font-size: 0.85rem;
    color: #777;
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
@include('partials.navbar')
<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary font-bold">Tambahkan Anggota Baru</h1>
        <div class="button-row">
            <a href="{{ route('anggota.home') }}" class="btn-add-user">Daftar Anggota</a>
            {{-- <a href="{{ route('users.template') }}" class="btn-add-user">Download CSV Template</a> --}}
        </div>

        <div class="card p-4">

            <!-- Toggle Option -->
            <div class="mb-3">
                <label class="form-label">Choose Input Method</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="input_method" id="input_manual" value="manual" checked>
                    <label class="form-check-label" for="input_manual">Input Manually</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="input_method" id="input_csv" value="csv">
                    <label class="form-check-label" for="input_csv">Upload CSV File</label>
                </div>

            </div>


            <!-- CSV File Upload Section -->
            <form id="csv_section" class="mb-3" action="{{ route('anggota.storeCSV') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                @csrf
                <label for="csv_file" class="form-label">Upload CSV File:</label>
                <input type="file" class="form-control" name="csv_file" id="csv_file" accept=".csv">
                <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
            </form>

            <!-- Manual Input Section -->
            <form id="manual_section" action="{{ route('anggota.store') }}" method="POST" enctype="multipart/form-data" style="display: block;">
                @csrf
            <div>
                <div class="row">
                    
                    <div class="col-md-6 mb-3">
                        <label for="ID_Kartu" class="form-label">ID Kartu</label>
                        <input type="text" class="form-control" id="ID_Kartu" name="ID_Kartu" placeholder="Enter Card ID">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="NIK" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="NIK" name="NIK" placeholder="Enter NIK" required>
                    </div>

                </div>
                <div class="row">
                    
                    <div class="col-md-6 mb-3">
                        <label for="Nama_Lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="Nama_Lengkap" name="Nama_Lengkap" placeholder="Enter Full Name" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="Nama_Buddhis" class="form-label">Nama Buddhis</label>
                        <input type="text" class="form-control" id="Nama_Buddhis" name="Nama_Buddhis" placeholder="Enter Full Name">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="Gelar_Akademis" class="form-label">Gelar Akademis</label>
                        <input type="text" class="form-control" id="Gelar_Akademis" name="Gelar_Akademis" placeholder="Gelar Akademis">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="Profesi" class="form-label">Profesi</label>
                        <input type="text" class="form-control" id="Profesi" name="Profesi" placeholder="Profesi/Pekerjaan">
                    </div>
                   
                    <div class="col-md-6 mb-3">
                        <label for="Email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="Email" name="Email" placeholder="Enter Email" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="No_HP" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="No_HP" name="No_HP" placeholder="Enter No HP" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="Jenis_Kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="Jenis_Kelamin" name="Jenis_Kelamin" required>
                            <option value="" disabled selected>Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="Alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="Alamat" name="Alamat" placeholder="Alamat Tinggal" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="Kota_Lahir" class="form-label">Kota Lahir</label>
                        <input type="text" class="form-control" id="Kota_Lahir" name="Kota_Lahir" placeholder="Kota Kelahiran" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="Tanggal_Lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="Tanggal_Lahir" name="Tanggal_Lahir" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="Golongan_Darah" class="form-label">Golongan Darah</label>
                        <select class="form-select" id="Golongan_Darah" name="Golongan_Darah">
                            <option value="" disabled selected>Golongan Darah</option>
                            <option value="O">O</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="Mengenal_Patria_Dari" class="form-label">Mengenal Patria Dari</label>
                        <input type="text" class="form-control" id="Mengenal_Patria_Dari" name="Mengenal_Patria_Dari" placeholder="Mengenal Patria Dari">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="Histori_Patria" class="form-label">Histori Patria</label>
                        <input type="text" class="form-control" id="Histori_Patria" name="Histori_Patria" placeholder="Histori Patria">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="Pernah_Mengikuti_PBT" class="form-label">Pernah Mengikuti PBT</label>
                        <select class="form-select" id="Pernah_Mengikuti_PBT" name="Pernah_Mengikuti_PBT" required>
                            <option value="" disabled selected>Pilih</option>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="dpd_id" class="form-label">DPD?</label>
                        <select class="form-select" id="dpd_id" name="dpd_id">
                            <option value="" selected>-- Pilih --</option>
                            @foreach ($dpds as $dpd)
                                <option value="{{ $dpd->id }}">
                                    {{ $dpd->nama_dpd }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="dpc_id" class="form-label">DPC?</label>
                        <select class="form-select" id="dpc_id" name="dpc_id">
                            <option value="" selected>-- Pilih --</option>
                            @foreach ($dpcs as $dpc)
                                <option value="{{ $dpc->id }}">
                                    {{ $dpc->nama_dpc }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama_penginput" class="form-label">Nama Penginput</label>
                        <input type="text" class="form-control" id="nama_penginput" name="nama_penginput" placeholder="Nama Penginput">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="jabatan_penginput" class="form-label">Jabatan Penginput</label>
                        <input type="text" class="form-control" id="jabatan_penginput" name="jabatan_penginput" placeholder="Jabatan Penginput">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="Status_Kartu" class="form-label">Status Kartu</label>
                        <select class="form-select" id="Status_Kartu" name="Status_Kartu">
                            <option value="" selected>-- Pilih --</option>
                            <option value="belum_cetak">Belum Cetak</option>
                            <option value="sudah_cetak">Sudah Cetak</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="keterangan" class="form-label">Keterangan Input</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan Input">
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                    </div>
                    

                    <!-- Image Preview -->
                    <img id="imagePreview" src="" alt="Preview Gambar" class="mt-3" style="max-width: 200px; display: none; border-radius: 8px; margin-bottom: 12px;">

                </div>
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
    </div>

    <!-- Toastify Script -->
    <script>

    const inputCsv = document.getElementById("input_csv");
    const inputManual = document.getElementById("input_manual");
    const csvSection = document.getElementById("csv_section");
    const manualSection = document.getElementById("manual_section");

    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "";
            preview.style.display = 'none';
        }
    }

    // Toggle sections based on selected input method
    inputManual.addEventListener("change", () => {
        if (inputManual.checked) {
            csvSection.style.display = "none";
            manualSection.style.display = "block";
        }
    });

    inputCsv.addEventListener("change", () => {
        if (inputCsv.checked) {
            csvSection.style.display = "block";
            manualSection.style.display = "none";
        }
    });

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

</script>
</body>
</html>
