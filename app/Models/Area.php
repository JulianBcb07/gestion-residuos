<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    /** @use HasFactory<\Database\Factories\AreaFactory> */
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


    // Relacion uno a muchos entre areas y gen semanal

    public function zonas_areas()
    {
        return $this->hasMany(ZonasAreas::class);
    }
}
