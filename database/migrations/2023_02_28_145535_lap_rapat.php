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
        Schema::create('lap_rapats', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('jenis', 20);
            $table->text('catatan');
            $table->string('author', 20);
            $table->string('tempat', 100);
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
        Schema::dropIfExists('lap_rapats');
    }
};