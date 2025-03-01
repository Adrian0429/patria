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
<div class="container mt-5">
    <h1 class="text-center text-primary font-bold">Edit Anggota</h1>
    <div class="button-row">
        <a href="{{ route('anggota.home') }}" class="btn-add-user">Daftar Anggota</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('anggota.update', $anggota->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="ID_Kartu" class="form-label">ID Kartu</label>
                    <input type="text" class="form-control" id="ID_Kartu" name="ID_Kartu" value="{{ old('ID_Kartu', $anggota->ID_Kartu) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="NIK" class="form-label">NIK</label>
                    <input type="text" class="form-control" id="NIK" name="NIK" value="{{ old('NIK', $anggota->NIK) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="Nama_Lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="Nama_Lengkap" name="Nama_Lengkap" value="{{ old('Nama_Lengkap', $anggota->Nama_Lengkap) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="Nama_Buddhis" class="form-label">Nama Buddhis</label>
                    <input type="text" class="form-control" id="Nama_Buddhis" name="Nama_Buddhis" value="{{ old('Nama_Buddhis', $anggota->Nama_Buddhis) }}">
                </div>

                    <div class="col-md-6 mb-3">
                        <label for="Gelar_Akademis" class="form-label">Gelar Akademis</label>
                        <input type="text" class="form-control" id="Gelar_Akademis" name="Gelar_Akademis" placeholder="Gelar Akademis" value="{{ old('Gelar_Akademis', $anggota->Gelar_Akademis) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="Profesi" class="form-label">Profesi</label>
                        <input type="text" class="form-control" id="Profesi" name="Profesi" placeholder="Profesi/Pekerjaan" value="{{ old('Profesi', $anggota->Profesi) }}">
                    </div>


                <div class="col-md-6 mb-3">
                    <label for="Email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="Email" name="Email" value="{{ old('Email', $anggota->Email) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="No_HP" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="No_HP" name="No_HP" value="{{ old('No_HP', $anggota->No_HP) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="Jenis_Kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="Jenis_Kelamin" name="Jenis_Kelamin" required>
                        <option value="Laki-laki" {{ $anggota->Jenis_Kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $anggota->Jenis_Kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="Alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="Alamat" name="Alamat" value="{{ old('Alamat', $anggota->Alamat) }}" required>
                </div>

                    <div class="col-md-6 mb-3">
                        <label for="Kota_Lahir" class="form-label">Kota Lahir</label>
                        <input type="text" class="form-control" id="Kota_Lahir" name="Kota_Lahir" placeholder="Kota Kelahiran" required value="{{ old('Kota_Lahir', $anggota->Kota_Lahir) }}">
                    </div>

                <div class="col-md-6 mb-3">
                    <label for="Tanggal_Lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="Tanggal_Lahir" name="Tanggal_Lahir" value="{{ old('Tanggal_Lahir', $anggota->Tanggal_Lahir) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="Golongan_Darah" class="form-label">Golongan Darah</label>
                    <select class="form-select" id="Golongan_Darah" name="Golongan_Darah">
                        <option value="O" {{ $anggota->Golongan_Darah == 'O' ? 'selected' : '' }}>O</option>
                        <option value="A" {{ $anggota->Golongan_Darah == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ $anggota->Golongan_Darah == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ $anggota->Golongan_Darah == 'AB' ? 'selected' : '' }}>AB</option>
                    </select>
                </div>

                 <div class="col-md-6 mb-3">
                        <label for="Mengenal_Patria_Dari" class="form-label">Mengenal Patria Dari</label>
                        <input type="text" class="form-control" id="Mengenal_Patria_Dari" name="Mengenal_Patria_Dari" placeholder="Mengenal Patria Dari" value="{{ old('Mengenal_Patria_Dari', $anggota->Mengenal_Patria_Dari) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="Histori_Patria" class="form-label">Histori Patria</label>
                        <input type="text" class="form-control" id="Histori_Patria" name="Histori_Patria" placeholder="Histori Patria" value="{{ old('Histori_Patria', $anggota->Histori_Patria) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="Pernah_Mengikuti_PBT" class="form-label">Pernah Mengikuti PBT</label>
                        <select class="form-select" id="Pernah_Mengikuti_PBT" name="Pernah_Mengikuti_PBT" required>
                            <option value="" disabled {{ old('Pernah_Mengikuti_PBT', $anggota->Pernah_Mengikuti_PBT) === null ? 'selected' : '' }}>Pilih</option>
                            <option value="1" {{ old('Pernah_Mengikuti_PBT', $anggota->Pernah_Mengikuti_PBT) == '1' ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ old('Pernah_Mengikuti_PBT', $anggota->Pernah_Mengikuti_PBT) == '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="dpd_id" class="form-label">DPD</label>
                        <select class="form-select" id="dpd_id" name="dpd_id">
                            <option value="" {{ $anggota->dpd_id === null ? 'selected' : '' }}>Pilih DPD</option>
                            @foreach ($dpds as $dpd)
                                <option value="{{ $dpd->id }}" {{ $anggota->dpd_id == $dpd->id ? 'selected' : '' }}>{{ $dpd->nama_dpd }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="dpc_id" class="form-label">DPC</label>
                        <select class="form-select" id="dpc_id" name="dpc_id">
                            <option value="" {{ $anggota->dpc_id === null ? 'selected' : '' }}>Pilih DPC</option>
                            @foreach ($dpcs as $dpc)
                                <option value="{{ $dpc->id }}" {{ $anggota->dpc_id == $dpc->id ? 'selected' : '' }}>{{ $dpc->nama_dpc }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="Status_Kartu" class="form-label">Status Kartu</label>
                        <select class="form-select" id="Status_Kartu" name="Status_Kartu">
                            <option value="" {{ old('Status_Kartu', $anggota->Status_Kartu) == '' ? 'selected' : '' }}>-- Pilih --</option>
                            <option value="belum_cetak" {{ old('Status_Kartu', $anggota->Status_Kartu) == 'belum_cetak' ? 'selected' : '' }}>Belum Cetak</option>
                            <option value="sudah_cetak" {{ old('Status_Kartu', $anggota->Status_Kartu) == 'sudah_cetak' ? 'selected' : '' }}>Sudah Cetak</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3 hidden">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama_penginput" class="form-label">Nama Editor</label>
                        <input type="text" class="form-control" id="nama_penginput" name="nama_penginput" placeholder="Nama Editor" value="{{ old('nama_penginput', $anggota->nama_penginput) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="jabatan_penginput" class="form-label">Jabatan Editor</label>
                        <input type="text" class="form-control" id="jabatan_penginput" name="jabatan_penginput" placeholder="Jabatan Editor" value="{{ old('jabatan_penginput', $anggota->jabatan_penginput) }}" required>
                    </div>
                    

                    <div class="col-md-6 mb-3">
                        <label for="keterangan" class="form-label">Keterangan Edit</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan Edit" value="{{ old('keterangan', $anggota->keterangan) }}" required>
                    </div>

                <div class="col-md-6 mb-3">
                    <label for="image" class="form-label">Gambar</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                </div>

                @if ($anggota->image)
                <div class="col-md-6 mb-3">
                    <img src="{{ asset('storage/' . $anggota->image) }}" alt="Preview Gambar" class="mt-3" style="max-width: 200px; border-radius: 8px;">
                </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary w-100">Update</button>
        </form>
    </div>
</div>
</body>
<script>
 document.addEventListener("DOMContentLoaded", function () {
        const dpdSelect = document.getElementById("dpd_id");
        const dpcSelect = document.getElementById("dpc_id");

        function handleSelectionChange(selected, other) {
            if (selected.value) {
                other.value = ""; // Clear the other field
                other.disabled = true; // Disable it
            } else {
                other.disabled = false; // Re-enable if nothing is selected
            }
        }
z
        dpdSelect.addEventListener("change", function () {
            handleSelectionChange(dpdSelect, dpcSelect);
        });

        dpcSelect.addEventListener("change", function () {
            handleSelectionChange(dpcSelect, dpdSelect);
        });
    });

</script>
</html>
