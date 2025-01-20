<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subproducto extends Model
{
    /** @use HasFactory<\Database\Factories\SubproductoFactory> */
    use HasFactory;

    // Relacion uno a muchos a nivel de eloquent

    public function genSubproducto()
    {
        return $this->hasMany(GenSubproducto::class);
    }
}
