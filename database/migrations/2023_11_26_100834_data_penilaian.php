<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DataPenilaian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_alternatif'); // Assuming it's an unsigned big integer
            $table->unsignedBigInteger('id_kriteria'); // Assuming it's an unsigned big integer
            $table->float('skor');
            $table->timestamps();
            $table->foreign('id_alternatif')->references('id')->on('alternatif')->onDelete('cascade');
            $table->foreign('id_kriteria')->references('id')->on('kriteriadan_bobot')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
