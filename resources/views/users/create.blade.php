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
    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary font-bold">Tambahkan Anggota Baru</h1>
        <div class="button-row">
            <a href="{{ route('users.home') }}" class="btn-add-user">Daftar Anggota</a>
            <a href="{{ route('users.template') }}" class="btn-add-user">Download CSV Template</a>
        </div>

        <div class="card p-4">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="csv_file" class="form-label">Upload CSV File:</label>
                    <input type="file"  class="form-control" name="csv_file" id="csv_file" accept=".csv">
                </div>
                <div class="row">
                    
                    <div class="col-md-6 mb-3">
                        <label for="card_id" class="form-label">Card ID</label>
                        <input type="text" class="form-control" id="card_id" name="card_id" placeholder="Enter Card ID">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="user_id" class="form-label">User ID</label>
                        <input type="text" class="form-control" id="user_id" name="user_id" placeholder="Enter User ID" required>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-6 mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Enter Full Name" required>
                    </div>
                   
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="" disabled selected>Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="golongan_darah" class="form-label">Golongan Darah</label>
                        <select class="form-select" id="golongan_darah" name="golongan_darah">
                            <option value="" disabled selected>Golongan Darah</option>
                            <option value="O">O</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                   
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Jabatan</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="" disabled selected>Jabatan</option>
                            <option value="DPP">DPP</option>
                            <option value="DPD">DPD</option>
                            <option value="DPC">DPC</option>
                            <option value="DPAC">DPAC</option>
                            <option value="Anggota">Anggota</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="vihara" class="form-label">Vihara</label>
                        <input type="text" class="form-control" id="vihara" name="vihara" placeholder="Enter Vihara" required>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="daerah" class="form-label">Daerah</label>
                    <select class="form-select" id="daerah" name="daerah" required>
                        <option value="" disabled selected>Pilih Daerah</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Profile Image</label>
                    <input type="file" class="form-control" id="image" name="image">
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
    // Array of provinsi
    const provinsi = [
        "Aceh", "Sumatera Utara", "Sumatera Barat", "Riau", "Kepulauan Riau", "Jambi",
        "Sumatera Selatan", "Bangka Belitung", "Bengkulu", "Lampung", "DKI Jakarta", "Banten",
        "Jawa Barat", "Jawa Tengah", "DI Yogyakarta", "Jawa Timur", "Bali", "Nusa Tenggara Barat",
        "Nusa Tenggara Timur", "Kalimantan Barat", "Kalimantan Tengah", "Kalimantan Selatan",
        "Kalimantan Timur", "Kalimantan Utara", "Sulawesi Utara", "Sulawesi Tengah",
        "Sulawesi Selatan", "Sulawesi Tenggara", "Sulawesi Barat", "Gorontalo", "Maluku",
        "Maluku Utara", "Papua", "Papua Barat", "Papua Tengah", "Papua Pegunungan", "Papua Selatan",
        "Papua Barat Daya"
    ];

    // Array of kabupaten
    const kabupaten = [
        "Banda Aceh", "Sabang", "Langsa", "Lhokseumawe", "Subulussalam", "Medan", "Binjai",
        "Tebing Tinggi", "Pematang Siantar", "Sibolga", "Padang", "Bukittinggi", "Payakumbuh",
        "Pariaman", "Solok", "Pekanbaru", "Dumai", "Tanjung Pinang", "Batam", "Jambi",
        "Sungai Penuh", "Palembang", "Lubuk Linggau", "Prabumulih", "Pagar Alam", "Pangkal Pinang",
        "Bengkulu", "Bandar Lampung", "Metro", "Jakarta Pusat", "Jakarta Barat", "Jakarta Timur",
        "Jakarta Selatan", "Jakarta Utara", "Serang", "Cilegon", "Tangerang", "Tangerang Selatan",
        "Bandung", "Bogor", "Bekasi", "Cimahi", "Depok", "Semarang", "Solo", "Magelang",
        "Pekalongan", "Salatiga", "Yogyakarta", "Surabaya", "Malang", "Kediri", "Blitar",
        "Denpasar", "Mataram", "Bima", "Kupang", "Ende", "Maumere", "Pontianak", "Singkawang",
        "Palangka Raya", "Banjarmasin", "Banjarbaru", "Samarinda", "Balikpapan", "Bontang",
        "Tanjung Selor", "Manado", "Bitung", "Tomohon", "Palu", "Makassar", "Parepare", "Palopo",
        "Kendari", "Baubau", "Mamuju", "Gorontalo", "Ambon", "Tual", "Ternate", "Tidore",
        "Jayapura", "Manokwari", "Sorong", "Nabire", "Wamena", "Merauke", "Fakfak", "Kaimana"
    ];

    const roleDropdown = document.getElementById("role");
    const daerahDropdown = document.getElementById("daerah");

    roleDropdown.addEventListener("change", () => {
        const role = roleDropdown.value;
        let options = []; // Clear options

        if (role === "DPP" || role === "DPD") {
            options = provinsi;
        } else if (role === "DPC" || role === "DPAC") {
            options = kabupaten;
        }

        daerahDropdown.innerHTML = `<option value="" disabled selected>Pilih Daerah</option>`;
        options.forEach(daerah => {
            const optionElement = document.createElement("option");
            optionElement.value = daerah;
            optionElement.textContent = daerah;
            daerahDropdown.appendChild(optionElement);
        });
    });
</script>
</body>
</html>
