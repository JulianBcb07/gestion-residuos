<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    /** @use HasFactory<\Database\Factories\PersonaFactory> */
    use HasFactory;

    // Relacion uno a muchos a nivel de eloquent

    public function personaInstitutos()
    {
        return $this->hasMany(PersonaInstituto::class);
    }
}
