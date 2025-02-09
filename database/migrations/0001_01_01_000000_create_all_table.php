<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('dpd', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dpd')->unique();
            $table->string('kode_daerah')->unique();
            $table->timestamps();
        });

        Schema::create('dpc', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dpc')->unique();
            $table->string('kode_daerah')->unique();
            $table->foreignId('dpd_id')->constrained('dpd')->onDelete('cascade');
            $table->timestamps();
        });

       Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jabatan', ['admin', 'DPP', 'DPD', 'DPC', 'DPAC', 'Anggota'])->default('Anggota');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('dpd_id')->nullable()->constrained('dpd')->onDelete('cascade');
            $table->foreignId('dpc_id')->nullable()->constrained('dpc')->onDelete('cascade');
            $table->rememberToken();  // Add this line
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('data_anggota', function (Blueprint $table) {
            $table->id();
            $table->string('ID_Kartu')->unique();
            $table->string('NIK')->unique();
            $table->string('Nama_Lengkap');
            $table->string('Nama_Buddhis')->nullable();
            $table->enum('Jenis_Kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('Kota_Lahir');
            $table->date('Tanggal_Lahir');
            $table->enum('Golongan_Darah', ['A', 'B', 'AB', 'O'])->nullable();
            $table->string('Gelar_Akademis')->nullable();
            $table->string('Profesi')->nullable();
            $table->string('Email');
            $table->string('No_HP');
            $table->text('Alamat');
            $table->string('img_link')->nullable();
            $table->enum('Status_Kartu', ['sudah_cetak', 'belum_cetak'])->default('belum_cetak');
            $table->text('Mengenal_Patria_Dari')->nullable();
            $table->text('Histori_Patria')->nullable();
            $table->boolean('Pernah_Mengikuti_PBT')->default(false);
            $table->foreignId('dpd_id')->nullable()->constrained('dpd')->onDelete('cascade');
            $table->foreignId('dpc_id')->nullable()->constrained('dpc')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('informasi_akses', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['create', 'read', 'update', 'delete']);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_anggota')->constrained('data_anggota')->onDelete('cascade');
            $table->string('nama_penginput')->nullable();
            $table->string('jabatan_penginput')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('nama_event');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Attendances Table
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('id_anggota')->constrained('data_anggota')->onDelete('cascade');
            $table->date('attendance_date');
            $table->timestamps();

        });

        
    }

    public function down()
    {
        Schema::dropIfExists('dpc');
        Schema::dropIfExists('dpd');
        Schema::dropIfExists('events');
        Schema::dropIfExists('informasi_akses');
        Schema::dropIfExists('data_anggota');
        Schema::dropIfExists('users');
    }
};
