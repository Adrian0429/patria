<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
        public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id', 20)->primary(); 
            $table->string('card_id', 20)->nullable()->unique();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_lahir');
            $table->string('golongan_darah');
            $table->string('vihara');
            $table->string('image_link')->nullable();
            $table->enum('role', ['admin', 'DPP', 'DPC', 'Anggota'])->default('Anggota');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id')->nullable()->index(); // Make this nullable
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null'); 
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }

}
