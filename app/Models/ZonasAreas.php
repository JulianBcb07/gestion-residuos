<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZonasAreas extends Model
{
    /** @use HasFactory<\Database\Factories\ZonasAreasFactory> */
    use HasFactory;

    // Relacion uno a muchos inversa a nivel eloquent entre zona y areas

    public function zonas()
    {
        return $this->belongsTo(Zona::class);
    }

    public function areas()
    {
        return $this->belongsTo(Area::class);
    }

    public function genSemanal()
    {
        return $this->hasMany(genSemanal::class);
    }
}
