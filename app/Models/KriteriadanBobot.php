<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriadanBobot extends Model
{
    use HasFactory;

    protected $table = 'kriteriadan_bobot';

    protected $fillable = [
        'kode_kriteria',
        'kriteria',
        'bobot',
        'jenis_kriteria',

    ];
}
