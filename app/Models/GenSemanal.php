<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenSemanal extends Model
{
    /** @use HasFactory<\Database\Factories\GenSemanalFactory> */
    use HasFactory;

    protected $fillable = [
        'zonas_areas_id',
        'fecha',
        'turno',
        'valor_kg',
    ];

    // Relacion uno a muchos inversa a nivel eloquent

    // Indico que una generacion semanal pertenece a un registro especifico entre una zona y un area
    public function zonas_areas()
    {
        return $this->belongsTo(ZonasAreas::class);
    }

    public function zonaArea()
    {
        return $this->belongsTo(ZonasAreas::class, 'zonas_areas_id');
    }
}
