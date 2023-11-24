<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

class CreateKriteriadanBobotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kriteriadan_bobot', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kriteria')->unique();
            $table->string('kriteria');
            $table->float('bobot');
            $table->enum('jenis_kriteria', ['benefit', 'cost']);
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
        Schema::dropIfExists('kriteriadan_bobot');
    }
}
