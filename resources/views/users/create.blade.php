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
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
@include('partials.navbar')
<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary font-bold">Tambahkan Anggota Baru</h1>
        <div class="button-row">
            <a href="{{ route('users.home') }}" class="btn-add-user">Daftar Anggota</a>
            <a href="{{ route('users.template') }}" class="btn-add-user">Download CSV Template</a>
        </div>

        <div class="card p-4">

            <!-- Toggle Option -->
            <div class="mb-3">
                <label class="form-label">Choose Input Method</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="input_method" id="input_csv" value="csv" checked>
                    <label class="form-check-label" for="input_csv">Upload CSV File</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="input_method" id="input_manual" value="manual">
                    <label class="form-check-label" for="input_manual">Input Manually</label>
                </div>
            </div>


            <!-- CSV File Upload Section -->
            <form id="csv_section" class="mb-3" action="{{ route('users.storeCSV') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="csv_file" class="form-label">Upload CSV File:</label>
                <input type="file" class="form-control" name="csv_file" id="csv_file" accept=".csv">
                <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
            </form>

            <!-- Manual Input Section -->
            <form id="manual_section" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                @csrf
            <div>
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
                            @if (auth()->user()->role == 'admin')
                                <option value="Admin">Admin</option>
                            @endif
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

    // Toggle sections based on selected input method
    inputCsv.addEventListener("change", () => {
        if (inputCsv.checked) {
            csvSection.style.display = "block";
            manualSection.style.display = "none";
        }
    });

    inputManual.addEventListener("change", () => {
        if (inputManual.checked) {
            csvSection.style.display = "none";
            manualSection.style.display = "block";
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


    const provinsi = [
    'Aceh',
    'Bali',
    'Banten',
    'Bengkulu',
    'DKI Jakarta',
    'Gorontalo',
    'Jambi',
    'Jawa Barat',
    'Jawa Tengah',
    'Jawa Timur',
    'Kalimantan Barat',
    'Kalimantan Selatan',
    'Kalimantan Tengah',
    'Kalimantan Timur',
    'Kalimantan Utara',
    'Kepulauan Bangka Belitung',
    'Kepulauan Riau',
    'Lampung',
    'Maluku',
    'Maluku Utara',
    'Nusa Tenggara Barat',
    'Nusa Tenggara Timur',
    'Papua',
    'Papua Barat',
    'Riau',
    'Sulawesi Barat',
    'Sulawesi Selatan',
    'Sulawesi Tengah',
    'Sulawesi Tenggara',
    'Sulawesi Utara',
    'Sumatera Barat',
    'Sumatera Selatan',
    'Sumatera Utara',
    'Yogyakarta',
    ];

    // Array of kabupaten
    const kabupaten = [
        'Kabupaten Simeulue', 'Kabupaten Aceh Barat', 'Kabupaten Aceh Barat Daya', 'Kabupaten Aceh Besar', 'Kabupaten Aceh Jaya', 'Kabupaten Aceh Selatan', 'Kabupaten Aceh Singkil', 'Kabupaten Aceh Tamiang', 'Kabupaten Aceh Tengah', 'Kabupaten Aceh Tenggara', 'Kabupaten Aceh Timur', 'Kabupaten Aceh Utara', 'Kabupaten Agam', 'Kabupaten Alor', 'Kabupaten Asahan', 'Kabupaten Asmat', 'Kabupaten Badung', 'Kabupaten Balangan', 'Kabupaten Bandung', 'Kabupaten Bandung Barat', 'Kabupaten Banggai', 'Kabupaten Banggai Kepulauan', 'Kabupaten Banggai Laut', 'Kabupaten Bangka', 'Kabupaten Bangka Barat', 'Kabupaten Bangka Selatan', 'Kabupaten Bangka Tengah', 'Kabupaten Bangkalan', 'Kabupaten Bangli', 'Kabupaten Banjar', 'Kabupaten Banjarnegara', 'Kabupaten Bantaeng', 'Kabupaten Bantul', 'Kabupaten Banyu Asin', 'Kabupaten Banyumas', 'Kabupaten Banyuwangi', 'Kabupaten Barito Kuala', 'Kabupaten Barito Selatan', 'Kabupaten Barito Timur', 'Kabupaten Barito Utara', 'Kabupaten Barru', 'Kabupaten Batang', 'Kabupaten Batang Hari', 'Kabupaten Batu Bara', 'Kabupaten Bekasi', 'Kabupaten Belitung', 'Kabupaten Belitung Timur', 'Kabupaten Belu', 'Kabupaten Bener Meriah', 'Kabupaten Bengkalis', 'Kabupaten Bengkayang', 'Kabupaten Bengkulu Selatan', 'Kabupaten Bengkulu Tengah', 'Kabupaten Bengkulu Utara', 'Kabupaten Berau', 'Kabupaten Biak Numfor', 'Kabupaten Bima', 'Kabupaten Bintan', 'Kabupaten Bireuen', 'Kabupaten Blitar', 'Kabupaten Blora', 'Kabupaten Boalemo', 'Kabupaten Bogor', 'Kabupaten Bojonegoro', 'Kabupaten Bolaang Mongondow', 'Kabupaten Bolaang Mongondow Selatan', 'Kabupaten Bolaang Mongondow Timur', 'Kabupaten Bolaang Mongondow Utara', 'Kabupaten Bombana', 'Kabupaten Bondowoso', 'Kabupaten Bone', 'Kabupaten Bone Bolango', 'Kabupaten Boven Digoel', 'Kabupaten Boyolali', 'Kabupaten Brebes', 'Kabupaten Buleleng', 'Kabupaten Bulukumba', 'Kabupaten Bulungan', 'Kabupaten Bungo', 'Kabupaten Buol', 'Kabupaten Buru', 'Kabupaten Buru Selatan', 'Kabupaten Buton', 'Kabupaten Buton Selatan', 'Kabupaten Buton Tengah', 'Kabupaten Buton Utara', 'Kabupaten Ciamis', 'Kabupaten Cianjur', 'Kabupaten Cilacap', 'Kabupaten Cirebon', 'Kabupaten Dairi', 'Kabupaten Deiyai', 'Kabupaten Deli Serdang', 'Kabupaten Demak', 'Kabupaten Dharmasraya', 'Kabupaten Dogiyai', 'Kabupaten Dompu', 'Kabupaten Donggala', 'Kabupaten Empat Lawang', 'Kabupaten Ende', 'Kabupaten Enrekang', 'Kabupaten Fakfak', 'Kabupaten Flores Timur', 'Kabupaten Garut', 'Kabupaten Gayo Lues', 'Kabupaten Gianyar', 'Kabupaten Gorontalo', 'Kabupaten Gorontalo Utara', 'Kabupaten Gowa', 'Kabupaten Gresik', 'Kabupaten Grobogan', 'Kabupaten Gunung Kidul', 'Kabupaten Gunung Mas', 'Kabupaten Halmahera Barat', 'Kabupaten Halmahera Selatan', 'Kabupaten Halmahera Tengah', 'Kabupaten Halmahera Timur', 'Kabupaten Halmahera Utara', 'Kabupaten Hulu Sungai Selatan', 'Kabupaten Hulu Sungai Tengah', 'Kabupaten Hulu Sungai Utara', 'Kabupaten Humbang Hasundutan', 'Kabupaten Indragiri Hilir', 'Kabupaten Indragiri Hulu', 'Kabupaten Indramayu', 'Kabupaten Intan Jaya', 'Kabupaten Jayapura', 'Kabupaten Jayawijaya', 'Kabupaten Jember', 'Kabupaten Jembrana', 'Kabupaten Jeneponto', 'Kabupaten Jepara', 'Kabupaten Jombang', 'Kabupaten Kaimana', 'Kabupaten Kampar', 'Kabupaten Kapuas', 'Kabupaten Kapuas Hulu', 'Kabupaten Karang Asem', 'Kabupaten Karanganyar', 'Kabupaten Karawang', 'Kabupaten Karimun', 'Kabupaten Karo', 'Kabupaten Katingan', 'Kabupaten Kaur', 'Kabupaten Kayong Utara', 'Kabupaten Kebumen', 'Kabupaten Kediri', 'Kabupaten Keerom', 'Kabupaten Kendal', 'Kabupaten Kepahiang', 'Kabupaten Kepulauan Anambas', 'Kabupaten Kepulauan Aru', 'Kabupaten Kepulauan Mentawai', 'Kabupaten Kepulauan Meranti', 'Kabupaten Kepulauan Sangihe', 'Kabupaten Kepulauan Selayar', 'Kabupaten Kepulauan Seribu', 'Kabupaten Kepulauan Sula', 'Kabupaten Kepulauan Talaud', 'Kabupaten Kepulauan Yapen', 'Kabupaten Kerinci', 'Kabupaten Ketapang', 'Kabupaten Klaten', 'Kabupaten Klungkung', 'Kabupaten Kolaka', 'Kabupaten Kolaka Timur', 'Kabupaten Kolaka Utara', 'Kabupaten Konawe', 'Kabupaten Konawe Kepulauan', 'Kabupaten Konawe Selatan', 'Kabupaten Konawe Utara', 'Kabupaten Kota Baru', 'Kabupaten Kotawaringin Barat', 'Kabupaten Kotawaringin Timur', 'Kabupaten Kuantan Singingi', 'Kabupaten Kubu Raya', 'Kabupaten Kudus', 'Kabupaten Kulon Progo', 'Kabupaten Kuningan', 'Kabupaten Kupang', 'Kabupaten Kutai Barat', 'Kabupaten Kutai Kartanegara', 'Kabupaten Kutai Timur', 'Kabupaten Labuhan Batu', 'Kabupaten Labuhan Batu Selatan', 'Kabupaten Labuhan Batu Utara', 'Kabupaten Lahat', 'Kabupaten Lamandau', 'Kabupaten Lamongan', 'Kabupaten Lampung Barat', 'Kabupaten Lampung Selatan', 'Kabupaten Lampung Tengah', 'Kabupaten Lampung Timur', 'Kabupaten Lampung Utara', 'Kabupaten Landak', 'Kabupaten Langkat', 'Kabupaten Lanny Jaya', 'Kabupaten Lebak', 'Kabupaten Lebong', 'Kabupaten Lembata', 'Kabupaten Lima Puluh Kota', 'Kabupaten Lingga', 'Kabupaten Lombok Barat', 'Kabupaten Lombok Tengah', 'Kabupaten Lombok Timur', 'Kabupaten Lombok Utara', 'Kabupaten Lumajang', 'Kabupaten Luwu', 'Kabupaten Luwu Timur', 'Kabupaten Luwu Utara', 'Kabupaten Madiun', 'Kabupaten Magelang', 'Kabupaten Magetan', 'Kabupaten Mahakam Hulu', 'Kabupaten Majalengka', 'Kabupaten Majene', 'Kabupaten Malaka', 'Kabupaten Malang', 'Kabupaten Malinau', 'Kabupaten Maluku Barat Daya', 'Kabupaten Maluku Tengah', 'Kabupaten Maluku Tenggara', 'Kabupaten Maluku Tenggara Barat', 'Kabupaten Mamasa', 'Kabupaten Mamberamo Raya', 'Kabupaten Mamberamo Tengah', 'Kabupaten Mamuju', 'Kabupaten Mamuju Tengah', 'Kabupaten Mamuju Utara', 'Kabupaten Mandailing Natal', 'Kabupaten Manggarai', 'Kabupaten Manggarai Barat', 'Kabupaten Manggarai Timur', 'Kabupaten Manokwari', 'Kabupaten Manokwari Selatan', 'Kabupaten Mappi', 'Kabupaten Maros', 'Kabupaten Maybrat', 'Kabupaten Melawi', 'Kabupaten Mempawah', 'Kabupaten Merangin', 'Kabupaten Merauke', 'Kabupaten Mesuji', 'Kabupaten Mimika', 'Kabupaten Minahasa', 'Kabupaten Minahasa Selatan', 'Kabupaten Minahasa Tenggara', 'Kabupaten Minahasa Utara', 'Kabupaten Mojokerto', 'Kabupaten Morowali', 'Kabupaten Morowali Utara', 'Kabupaten Muara Enim', 'Kabupaten Muaro Jambi', 'Kabupaten Mukomuko', 'Kabupaten Muna', 'Kabupaten Muna Barat', 'Kabupaten Murung Raya', 'Kabupaten Musi Banyuasin', 'Kabupaten Musi Rawas', 'Kabupaten Musi Rawas Utara', 'Kabupaten Nabire', 'Kabupaten Nagan Raya', 'Kabupaten Nagekeo', 'Kabupaten Natuna', 'Kabupaten Nduga', 'Kabupaten Ngada', 'Kabupaten Nganjuk', 'Kabupaten Ngawi', 'Kabupaten Nias', 'Kabupaten Nias Barat', 'Kabupaten Nias Selatan', 'Kabupaten Nias Utara', 'Kabupaten Nunukan', 'Kabupaten Ogan Ilir', 'Kabupaten Ogan Komering Ilir', 'Kabupaten Ogan Komering Ulu', 'Kabupaten Ogan Komering Ulu Selatan', 'Kabupaten Ogan Komering Ulu Timur', 'Kabupaten Pacitan', 'Kabupaten Padang Lawas', 'Kabupaten Padang Lawas Utara', 'Kabupaten Padang Pariaman', 'Kabupaten Pakpak Bharat', 'Kabupaten Pamekasan', 'Kabupaten Pandeglang', 'Kabupaten Pangandaran', 'Kabupaten Pangkajene Dan Kepulauan', 'Kabupaten Paniai', 'Kabupaten Parigi Moutong', 'Kabupaten Pasaman', 'Kabupaten Pasaman Barat', 'Kabupaten Paser', 'Kabupaten Pasuruan', 'Kabupaten Pati', 'Kabupaten Pegunungan Arfak', 'Kabupaten Pegunungan Bintang', 'Kabupaten Pekalongan', 'Kabupaten Pelalawan', 'Kabupaten Pemalang', 'Kabupaten Penajam Paser Utara', 'Kabupaten Penukal Abab Lematang Ilir', 'Kabupaten Pesawaran', 'Kabupaten Pesisir Barat', 'Kabupaten Pesisir Selatan', 'Kabupaten Pidie', 'Kabupaten Pidie Jaya', 'Kabupaten Pinrang', 'Kabupaten Pohuwato', 'Kabupaten Polewali Mandar', 'Kabupaten Ponorogo', 'Kabupaten Poso', 'Kabupaten Pringsewu', 'Kabupaten Probolinggo', 'Kabupaten Pulang Pisau', 'Kabupaten Pulau Morotai', 'Kabupaten Pulau Taliabu', 'Kabupaten Puncak', 'Kabupaten Puncak Jaya', 'Kabupaten Purbalingga', 'Kabupaten Purwakarta', 'Kabupaten Purworejo', 'Kabupaten Raja Ampat', 'Kabupaten Rejang Lebong', 'Kabupaten Rembang', 'Kabupaten Rokan Hilir', 'Kabupaten Rokan Hulu', 'Kabupaten Rote Ndao', 'Kabupaten Sabu Raijua', 'Kabupaten Sambas', 'Kabupaten Samosir', 'Kabupaten Sampang', 'Kabupaten Sanggau', 'Kabupaten Sarmi', 'Kabupaten Sarolangun', 'Kabupaten Sekadau', 'Kabupaten Seluma', 'Kabupaten Semarang', 'Kabupaten Seram Bagian Barat', 'Kabupaten Seram Bagian Timur', 'Kabupaten Serang', 'Kabupaten Serdang Bedagai', 'Kabupaten Seruyan', 'Kabupaten Siak', 'Kabupaten Siau Tagulandang Biaro', 'Kabupaten Sidenreng Rappang', 'Kabupaten Sidoarjo', 'Kabupaten Sigi', 'Kabupaten Sijunjung', 'Kabupaten Sikka', 'Kabupaten Simalungun', 'Kabupaten Sinjai', 'Kabupaten Sintang', 'Kabupaten Situbondo', 'Kabupaten Sleman', 'Kabupaten Solok', 'Kabupaten Solok Selatan', 'Kabupaten Soppeng', 'Kabupaten Sorong', 'Kabupaten Sorong Selatan', 'Kabupaten Sragen', 'Kabupaten Subang', 'Kabupaten Sukabumi', 'Kabupaten Sukamara', 'Kabupaten Sukoharjo', 'Kabupaten Sumba Barat', 'Kabupaten Sumba Barat Daya', 'Kabupaten Sumba Tengah', 'Kabupaten Sumba Timur', 'Kabupaten Sumbawa', 'Kabupaten Sumbawa Barat', 'Kabupaten Sumedang', 'Kabupaten Sumenep', 'Kabupaten Supiori', 'Kabupaten Tabalong', 'Kabupaten Tabanan', 'Kabupaten Takalar', 'Kabupaten Tambrauw', 'Kabupaten Tana Tidung', 'Kabupaten Tana Toraja', 'Kabupaten Tanah Bumbu', 'Kabupaten Tanah Datar', 'Kabupaten Tanah Laut', 'Kabupaten Tangerang', 'Kabupaten Tanggamus', 'Kabupaten Tanjung Jabung Barat', 'Kabupaten Tanjung Jabung Timur', 'Kabupaten Tapanuli Selatan', 'Kabupaten Tapanuli Tengah', 'Kabupaten Tapanuli Utara', 'Kabupaten Tapin', 'Kabupaten Tasikmalaya', 'Kabupaten Tebo', 'Kabupaten Tegal', 'Kabupaten Teluk Bintuni', 'Kabupaten Teluk Wondama', 'Kabupaten Temanggung', 'Kabupaten Timor Tengah Selatan', 'Kabupaten Timor Tengah Utara', 'Kabupaten Toba Samosir', 'Kabupaten Tojo Una-una', 'Kabupaten Toli-toli', 'Kabupaten Tolikara', 'Kabupaten Toraja Utara', 'Kabupaten Trenggalek', 'Kabupaten Tuban', 'Kabupaten Tulang Bawang Barat', 'Kabupaten Tulangbawang', 'Kabupaten Tulungagung', 'Kabupaten Wajo', 'Kabupaten Wakatobi', 'Kabupaten Waropen', 'Kabupaten Way Kanan', 'Kabupaten Wonogiri', 'Kabupaten Wonosobo', 'Kabupaten Yahukimo', 'Kabupaten Yalimo', 'Kota Ambon', 'Kota Balikpapan', 'Kota Banda Aceh', 'Kota Bandar Lampung', 'Kota Bandung', 'Kota Banjar', 'Kota Banjar Baru', 'Kota Banjarmasin', 'Kota Batam', 'Kota Batu', 'Kota Baubau', 'Kota Bekasi', 'Kota Bengkulu', 'Kota Bima', 'Kota Binjai', 'Kota Bitung', 'Kota Blitar', 'Kota Bogor', 'Kota Bontang', 'Kota Bukittinggi', 'Kota Cilegon', 'Kota Cimahi', 'Kota Cirebon', 'Kota Denpasar', 'Kota Depok', 'Kota Dumai', 'Kota Gorontalo', 'Kota Gunungsitoli', 'Kota Jakarta Barat', 'Kota Jakarta Pusat', 'Kota Jakarta Selatan', 'Kota Jakarta Timur', 'Kota Jakarta Utara', 'Kota Jambi', 'Kota Jayapura', 'Kota Kediri', 'Kota Kendari', 'Kota Kotamobagu', 'Kota Kupang', 'Kota Langsa', 'Kota Lhokseumawe', 'Kota Lubuklinggau', 'Kota Madiun', 'Kota Magelang', 'Kota Makassar', 'Kota Malang', 'Kota Manado', 'Kota Mataram', 'Kota Medan', 'Kota Metro', 'Kota Mojokerto', 'Kota Padang', 'Kota Padang Panjang', 'Kota Padangsidimpuan', 'Kota Pagar Alam', 'Kota Palangka Raya', 'Kota Palembang', 'Kota Palopo', 'Kota Palu', 'Kota Pangkal Pinang', 'Kota Parepare', 'Kota Pariaman', 'Kota Pasuruan', 'Kota Payakumbuh', 'Kota Pekalongan', 'Kota Pekanbaru', 'Kota Pematang Siantar', 'Kota Pontianak', 'Kota Prabumulih', 'Kota Probolinggo', 'Kota Sabang', 'Kota Salatiga', 'Kota Samarinda', 'Kota Sawah Lunto', 'Kota Semarang', 'Kota Serang', 'Kota Sibolga', 'Kota Singkawang', 'Kota Solok', 'Kota Sorong', 'Kota Subulussalam', 'Kota Sukabumi', 'Kota Sungai Penuh', 'Kota Surabaya', 'Kota Surakarta', 'Kota Tangerang', 'Kota Tangerang Selatan', 'Kota Tanjung Balai', 'Kota Tanjung Pinang', 'Kota Tarakan', 'Kota Tasikmalaya', 'Kota Tebing Tinggi', 'Kota Tegal', 'Kota Ternate', 'Kota Tidore Kepulauan', 'Kota Tomohon', 'Kota Tual', 'Kota Yogyakarta'
    ];

    const roleDropdown = document.getElementById("role");
    const daerahDropdown = document.getElementById("daerah");

    roleDropdown.addEventListener("change", () => {
        const role = roleDropdown.value;
        let options = []; // Clear options

        if (role === "DPP" || role === "DPD") {
            options = provinsi;
        } else if (role === "DPC" || role === "DPAC" || role === "Anggota") {
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
