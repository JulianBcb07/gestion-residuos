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

    public function zona()
    {
        return $this->belongsTo(Zona::class, 'zona_id');
    }


    public function areas()
    {
        return $this->belongsTo(Area::class);
    }

    // Indico que un registro de zonas_areas (zona_id con su area_id puede tener muchos registros de generacion semanal)
    public function genSemanal()
    {
        return $this->hasMany(genSemanal::class);
    }
}
