<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenSemanal extends Model
{
    /** @use HasFactory<\Database\Factories\GenSemanalFactory> */
    use HasFactory;

    // Relacion uno a muchos inversa a nivel eloquent

    public function zonas_areas()
    {
        return $this->belongsTo(ZonasAreas::class);
    }
}
