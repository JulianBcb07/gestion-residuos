<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaInstituto extends Model
{
    /** @use HasFactory<\Database\Factories\PersonaInstitutoFactory> */
    use HasFactory;

    // Relacion uno a muchos inversa a nivel de eloquent

    public function instituto()
    {
        return $this->belongsTo(Institutos::class);
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }
}
