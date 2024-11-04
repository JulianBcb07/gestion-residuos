<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenSubproducto extends Model
{
    /** @use HasFactory<\Database\Factories\GenSubprodcutoFactory> */
    use HasFactory;

    // Relacion uno a muchos inversa a nivel de eloquent

    public function instituto()
    {
        return $this->belongsTo(Institutos::class);
    }

    public function subproductos()
    {
        return $this->belongsTo(Subproducto::class);
    }
}