<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    /** @use HasFactory<\Database\Factories\ZonaFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'instituto_id',
    ];

    // Relacion uno a muchos inversa a nivel de eloquent

    public function instituto()
    {
        return $this->belongsTo(Institutos::class);
    }

    /**
     * Relación muchos a muchos con Area a través de la tabla zonas_areas.
     */
    public function areas()
    {
        return $this->belongsToMany(Area::class, 'zonas_areas', 'zona_id', 'area_id');
    }
}
