<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biodatas', function (Blueprint $table) {
            $table->id('id_bio');
            $table->string('nim', 13)->unique();
            $table->string('nama_lengkap', 255);
            $table->string('nama_cantik', 50);
            $table->string('jenis_kelamin', 1);
            $table->string('tempat_lahir', 30)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_wa', 13)->nullable();
            $table->text('bio')->nullable();
            $table->integer('angkatan');
            $table->integer('divisi_id')->nullable();
            $table->text('hobi')->nullable();
            $table->string('email', 50)->nullable();
            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->text('github')->nullable();
            $table->text('linkedin')->nullable();
            $table->string('status', 1)->nullable();
            $table->text('foto')->nullable();
            $table->string('profesi', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('biodatas');
    }
};
