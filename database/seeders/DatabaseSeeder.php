<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\DPC;
use App\Models\DPD;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $dpds = [
            ['nama_dpd' => 'DPD PATRIA SUMATERA UTARA', 'kode_daerah' => '12'],
            ['nama_dpd' => 'DPD PATRIA RIAU', 'kode_daerah' => '14'],
            ['nama_dpd' => 'DPD PATRIA JAMBI', 'kode_daerah' => '15'],
            ['nama_dpd' => 'DPD PATRIA SUMATERA SELATAN', 'kode_daerah' => '16'],
            ['nama_dpd' => 'DPD PATRIA LAMPUNG', 'kode_daerah' => '18'],
            ['nama_dpd' => 'DPD PATRIA KEPULAUAN RIAU', 'kode_daerah' => '21'],
            ['nama_dpd' => 'DPD PATRIA DKI JAKARTA', 'kode_daerah' => '31'],
            ['nama_dpd' => 'DPD PATRIA JAWA BARAT', 'kode_daerah' => '32'],
            ['nama_dpd' => 'DPD PATRIA JAWA TENGAH', 'kode_daerah' => '33'],
            ['nama_dpd' => 'DPD PATRIA DI YOGYAKARTA', 'kode_daerah' => '34'],
            ['nama_dpd' => 'DPD PATRIA JATIM', 'kode_daerah' => '35'],
            ['nama_dpd' => 'DPD PATRIA BANTEN', 'kode_daerah' => '36'],
            ['nama_dpd' => 'DPD PATRIA BALI', 'kode_daerah' => '51'],
            ['nama_dpd' => 'DPD PATRIA NTB', 'kode_daerah' => '52'],
            ['nama_dpd' => 'DPD PATRIA KALIMANTAN BARAT', 'kode_daerah' => '61'],
            ['nama_dpd' => 'DPD PATRIA KALIMANTAN TENGAH', 'kode_daerah' => '62'],
            ['nama_dpd' => 'DPD PATRIA KALIMANTAN SELATAN', 'kode_daerah' => '63'],
            ['nama_dpd' => 'DPD PATRIA KALIMANTAN TIMUR', 'kode_daerah' => '64'],
            ['nama_dpd' => 'DPD PATRIA KALIMANTAN UTARA', 'kode_daerah' => '65'],
            ['nama_dpd' => 'DPD PATRIA SULAWESI TENGAH', 'kode_daerah' => '72'],
            ['nama_dpd' => 'DPD PATRIA SULAWESI SELATAN', 'kode_daerah' => '73'],
            ['nama_dpd' => 'DPD PATRIA SULAWESI TENGGARA', 'kode_daerah' => '74'],
            ['nama_dpd' => 'DPD PATRIA SULAWESI BARAT', 'kode_daerah' => '76'],
            ['nama_dpd' => 'DPD PATRIA PAPUA', 'kode_daerah' => '91'],
        ];

        foreach ($dpds as $dpd) {
            DPD::create($dpd);
        }

        $dpcs = [
            ['dpd_id' => 1, 'nama_dpc' => 'DPC PATRIA MEDAN', 'kode_daerah' => '1201'],
            ['dpd_id' => 1, 'nama_dpc' => 'DPC PATRIA ASAHAN', 'kode_daerah' => '1202'],
            ['dpd_id' => 1, 'nama_dpc' => 'DPC PATRIA DELI SERDANG', 'kode_daerah' => '1203'],
            ['dpd_id' => 2, 'nama_dpc' => 'DPC PATRIA PEKANBARU', 'kode_daerah' => '1401'],
            ['dpd_id' => 3, 'nama_dpc' => 'DPC PATRIA KOTA JAMBI', 'kode_daerah' => '1501'],
            ['dpd_id' => 4, 'nama_dpc' => 'DPC PATRIA PALEMBANG', 'kode_daerah' => '1601'],
            ['dpd_id' => 4, 'nama_dpc' => 'DPC PATRIA KOTA LUBUKLINGGAU', 'kode_daerah' => '1602'],
            ['dpd_id' => 5, 'nama_dpc' => 'DPC PATRIA BANDAR LAMPUNG', 'kode_daerah' => '1801'],
            ['dpd_id' => 5, 'nama_dpc' => 'DPC PATRIA LAMPUNG TIMUR', 'kode_daerah' => '1802'],
            ['dpd_id' => 6, 'nama_dpc' => 'DPC PATRIA TANJUNG PINANG', 'kode_daerah' => '2101'],
            ['dpd_id' => 6, 'nama_dpc' => 'DPC PATRIA BATAM', 'kode_daerah' => '2102'],
            ['dpd_id' => 6, 'nama_dpc' => 'DPC PATRIA KAB. KARIMUN', 'kode_daerah' => '2103'],
            ['dpd_id' => 6, 'nama_dpc' => 'DPC PATRIA KAB. BINTAN', 'kode_daerah' => '2104'],
            ['dpd_id' => 6, 'nama_dpc' => 'DPAC PATRIA KEC. BATU AJI', 'kode_daerah' => '2105'],
            ['dpd_id' => 7, 'nama_dpc' => 'DPC PATRIA JAKARTA UTARA', 'kode_daerah' => '3101'],
            ['dpd_id' => 7, 'nama_dpc' => 'DPC JAKARTA BARAT', 'kode_daerah' => '3102'],
            ['dpd_id' => 7, 'nama_dpc' => 'DPC PATRIA JAKARTA TIMUR', 'kode_daerah' => '3103'],
            ['dpd_id' => 8, 'nama_dpc' => 'DPC PATRIA BANDUNG', 'kode_daerah' => '3201'],
            ['dpd_id' => 8, 'nama_dpc' => 'DPC PATRIA CIREBON', 'kode_daerah' => '3202'],
            ['dpd_id' => 8, 'nama_dpc' => 'DPC PATRIA GARUT', 'kode_daerah' => '3203'],
            ['dpd_id' => 8, 'nama_dpc' => 'DPC PATRIA KUNINGAN', 'kode_daerah' => '3204'],
            ['dpd_id' => 8, 'nama_dpc' => 'DPC PATRIA KAB. BEKASI', 'kode_daerah' => '3205'],
            ['dpd_id' => 8, 'nama_dpc' => 'DPC PATRIA KOTA BEKASI', 'kode_daerah' => '3206'],
            ['dpd_id' => 8, 'nama_dpc' => 'DPC PATRIA KOTA DEPOK', 'kode_daerah' => '3207'],
            ['dpd_id' => 8, 'nama_dpc' => 'DPC PATRIA KOTA BOGOR', 'kode_daerah' => '3208'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA KOTA SEMARANG', 'kode_daerah' => '3301'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA KAB. SEMARANG', 'kode_daerah' => '3302'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA BANYUMAS', 'kode_daerah' => '3303'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA PATI', 'kode_daerah' => '3304'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA KUDUS', 'kode_daerah' => '3305'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA REMBANG', 'kode_daerah' => '3306'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA BREBES', 'kode_daerah' => '3307'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA KLATEN', 'kode_daerah' => '3308'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA KAB. TEMANGGUNG', 'kode_daerah' => '3309'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA WONOGIRI', 'kode_daerah' => '3310'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA PURWOREJO', 'kode_daerah' => '3311'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA KAB. MAGELANG', 'kode_daerah' => '3312'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA JEPARA', 'kode_daerah' => '3313'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA PEKALONGAN', 'kode_daerah' => '3314'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA KEBUMEN', 'kode_daerah' => '3315'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA KOTA TEGAL', 'kode_daerah' => '3316'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA GROBOGAN', 'kode_daerah' => '3317'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA BANJARNEGARA', 'kode_daerah' => '3318'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA WONOSOBO', 'kode_daerah' => '3319'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA SURAKARTA', 'kode_daerah' => '3320'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA CILACAP', 'kode_daerah' => '3321'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA KENDAL', 'kode_daerah' => '3322'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA BOYOLALI', 'kode_daerah' => '3323'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA KAB. TEGAL', 'kode_daerah' => '3324'],
            ['dpd_id' => 9, 'nama_dpc' => 'DPC PATRIA SALATIGA', 'kode_daerah' => '3325'],
            ['dpd_id' => 10, 'nama_dpc' => 'DPC PATRIA KOTA YOGYAKARTA', 'kode_daerah' => '3401'],
            ['dpd_id' => 10, 'nama_dpc' => 'DPC PATRIA KULON PROGO', 'kode_daerah' => '3402'],
            ['dpd_id' => 11, 'nama_dpc' => 'DPC PATRIA KAB. MALANG', 'kode_daerah' => '3501'],
            ['dpd_id' => 11, 'nama_dpc' => 'DPC PATRIA SURABAYA', 'kode_daerah' => '3502'],
            ['dpd_id' => 11, 'nama_dpc' => 'DPC PATRIA BLITAR', 'kode_daerah' => '3503'],
            ['dpd_id' => 11, 'nama_dpc' => 'DPC PATRIA BANYUWANGI', 'kode_daerah' => '3504'],
            ['dpd_id' => 11, 'nama_dpc' => 'DPC PATRIA TULUNGAGUNG', 'kode_daerah' => '3505'],
            ['dpd_id' => 11, 'nama_dpc' => 'DPC PATRIA MAGETAN', 'kode_daerah' => '3506'],
            ['dpd_id' => 11, 'nama_dpc' => 'DPC PATRIA PONOROGO', 'kode_daerah' => '3507'],
            ['dpd_id' => 11, 'nama_dpc' => 'DPC PATRIA BATU', 'kode_daerah' => '3508'],
            ['dpd_id' => 11, 'nama_dpc' => 'DPAC PATRIA KEC. KASEMBON', 'kode_daerah' => '3509'],
            ['dpd_id' => 12, 'nama_dpc' => 'DPC PATRIA KOTA TANGERANG', 'kode_daerah' => '3601'],
            ['dpd_id' => 12, 'nama_dpc' => 'DPC PATRIA KAB. TANGERANG', 'kode_daerah' => '3602'],
            ['dpd_id' => 12, 'nama_dpc' => 'DPC PATRIA KOTA TANGERANG SELATAN', 'kode_daerah' => '3603'],
            ['dpd_id' => 12, 'nama_dpc' => 'DPC PATRIA KOTA SERANG', 'kode_daerah' => '3604'],
            ['dpd_id' => 12, 'nama_dpc' => 'DPAC PATRIA KAB. TANGERANG UTARA', 'kode_daerah' => '3605'],
            ['dpd_id' => 13, 'nama_dpc' => 'DPC PATRIA DENPASAR', 'kode_daerah' => '5101'],
            ['dpd_id' => 13, 'nama_dpc' => 'DPC PATRIA GIANYAR', 'kode_daerah' => '5102'],
            ['dpd_id' => 13, 'nama_dpc' => 'DPC PATRIA BULELENG', 'kode_daerah' => '5103'],
            ['dpd_id' => 13, 'nama_dpc' => 'DPC PATRIA TABANAN', 'kode_daerah' => '5104'],
            ['dpd_id' => 13, 'nama_dpc' => 'DPC PATRIA JEMBRANA', 'kode_daerah' => '5105'],
            ['dpd_id' => 13, 'nama_dpc' => 'DPC PATRIA KLUNGKUNG', 'kode_daerah' => '5106'],
            ['dpd_id' => 13, 'nama_dpc' => 'DPC PATRIA BANGLI', 'kode_daerah' => '5107'],
            ['dpd_id' => 13, 'nama_dpc' => 'DPC PATRIA KARANGASEM', 'kode_daerah' => '5108'],
            ['dpd_id' => 14, 'nama_dpc' => 'DPC PATRIA MATARAM', 'kode_daerah' => '5201'],
            ['dpd_id' => 14, 'nama_dpc' => 'DPC PATRIA LOMBOK BARAT', 'kode_daerah' => '5202'],
            ['dpd_id' => 14, 'nama_dpc' => 'DPC PATRIA LOMBOK UTARA', 'kode_daerah' => '5203'],
            ['dpd_id' => 15, 'nama_dpc' => 'DPC PATRIA KETAPANG', 'kode_daerah' => '6101'],
            ['dpd_id' => 15, 'nama_dpc' => 'DPC PATRIA PONTIANAK', 'kode_daerah' => '6102'],
            ['dpd_id' => 15, 'nama_dpc' => 'DPC PATRIA SINGKAWANG', 'kode_daerah' => '6103'],
            ['dpd_id' => 15, 'nama_dpc' => 'DPC PATRIA KUBU RAYA', 'kode_daerah' => '6104'],
            ['dpd_id' => 15, 'nama_dpc' => 'DPC PATRIA MEMPAWAH', 'kode_daerah' => '6105'],
            ['dpd_id' => 15, 'nama_dpc' => 'DPAC PATRIA PONTIANAK BARAT', 'kode_daerah' => '6106'],
            ['dpd_id' => 15, 'nama_dpc' => 'DPC PATRIA BENGKAYANG', 'kode_daerah' => '6107'],
            ['dpd_id' => 16, 'nama_dpc' => 'DPC PATRIA SAMPIT', 'kode_daerah' => '6201'],
            ['dpd_id' => 17, 'nama_dpc' => 'DPC PATRIA BANJARMASIN', 'kode_daerah' => '6301'],
            ['dpd_id' => 17, 'nama_dpc' => 'DPC PATRIA BALANGAN', 'kode_daerah' => '6302'],
            ['dpd_id' => 18, 'nama_dpc' => 'DPC PATRIA SAMARINDA', 'kode_daerah' => '6401'],
            ['dpd_id' => 18, 'nama_dpc' => 'DPC PATRIA BALIKPAPAN', 'kode_daerah' => '6402'],
            ['dpd_id' => 18, 'nama_dpc' => 'DPC PATRIA BERAU', 'kode_daerah' => '6403'],
            ['dpd_id' => 19, 'nama_dpc' => 'DPC PATRIA TARAKAN', 'kode_daerah' => '6501'],
            ['dpd_id' => 19, 'nama_dpc' => 'DPC PATRIA BULUNGAN', 'kode_daerah' => '6502'],
            ['dpd_id' => 20, 'nama_dpc' => 'DPC PATRIA PALU', 'kode_daerah' => '7201'],
            ['dpd_id' => 20, 'nama_dpc' => 'DPC PATRIA TOLI-TOLI', 'kode_daerah' => '7202'],
            ['dpd_id' => 20, 'nama_dpc' => 'DPC PATRIA MOROWALI', 'kode_daerah' => '7203'],
            ['dpd_id' => 20, 'nama_dpc' => 'DPC PATRIA KAB. BANGGAI', 'kode_daerah' => '7204'],
            ['dpd_id' => 21, 'nama_dpc' => 'DPC PATRIA BONE', 'kode_daerah' => '7301'],
            ['dpd_id' => 21, 'nama_dpc' => 'DPC PATRIA PARE-PARE', 'kode_daerah' => '7302'],
            ['dpd_id' => 21, 'nama_dpc' => 'DPC PATRIA MAKASSAR', 'kode_daerah' => '7303'],
            ['dpd_id' => 22, 'nama_dpc' => 'DPC PATRIA KENDARI', 'kode_daerah' => '7401'],
            ['dpd_id' => 23, 'nama_dpc' => 'DPC PATRIA MAMUJU', 'kode_daerah' => '7601'],
            ['dpd_id' => 24, 'nama_dpc' => 'DPC PATRIA KOTA JAYAPURA', 'kode_daerah' => '9101'],
        ];

        foreach ($dpcs as $dpc) {
            DPC::create($dpc);
        }

         $users = [
            [
                'nama' => 'Sekretariat DPP',
                'jabatan' => 'DPP',
                'email' => 'sekretariat.dpp@patria.or.id',
                'password' => Hash::make('admin12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sekretaris',
                'jabatan' => 'admin',
                'email' => 'sekretaris@patria.or.id',
                'password' => Hash::make('admin12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sekretaris Umum',
                'jabatan' => 'admin',
                'email' => 'sekretaris.umum@patria.or.id',
                'password' => Hash::make('admin12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sekretariat DPD JATENG',
                'jabatan' => 'DPD',
                'dpd_id' => 9,
                'email' => 'sekretariat.dpd.jateng@patria.or.id',
                'password' => Hash::make('admin12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama' => 'Sekretariat DPC SEMARANG KOTA',
                'jabatan' => 'DPC',
                'dpc_id' => 26,
                'email' => 'sekretariat.dpc.semarang@patria.or.id',
                'password' => Hash::make('admin12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
        
        DB::table('data_anggota')->insert([
            [
                'NIK' => '11111111111',
                'ID_Kartu' => 'kartu1',
                'Nama_Lengkap' => 'John Doe',
                'Nama_Buddhis' => 'Bhikku Ananda',
                'Jenis_Kelamin' => 'Laki-laki',
                'Kota_Lahir' => 'Jakarta',
                'Tanggal_Lahir' => Carbon::parse('1990-05-15'),
                'Golongan_Darah' => 'O',
                'Gelar_Akademis' => 'S.T.',
                'Profesi' => 'Engineer',
                'Email' => 'johndoe@example.com',
                'No_HP' => '081234567890',
                'Alamat' => 'Jl. Sudirman No.1, Jakarta',
                'img_link' => null,
                'Status_Kartu' => 'belum_cetak',
                'Mengenal_Patria_Dari' => 'Teman',
                'Histori_Patria' => 'Pernah mengikuti seminar',
                'Pernah_Mengikuti_PBT' => true,
                'dpc_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'NIK' => '22222222222',
                'ID_Kartu' => 'kartu2',
                'Nama_Lengkap' => 'Jane Smith',
                'Nama_Buddhis' => 'Sister Metta',
                'Jenis_Kelamin' => 'Perempuan',
                'Kota_Lahir' => 'Surabaya',
                'Tanggal_Lahir' => Carbon::parse('1995-10-20'),
                'Golongan_Darah' => 'A',
                'Gelar_Akademis' => 'M.Sc.',
                'Profesi' => 'Doctor',
                'Email' => 'janesmith@example.com',
                'No_HP' => '082345678901',
                'Alamat' => 'Jl. Ahmad Yani No.2, Surabaya',
                'img_link' => null,
                'Status_Kartu' => 'sudah_cetak',
                'Mengenal_Patria_Dari' => 'Keluarga',
                'Histori_Patria' => 'Pernah mengikuti retret',
                'Pernah_Mengikuti_PBT' => false,
                'dpd_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
