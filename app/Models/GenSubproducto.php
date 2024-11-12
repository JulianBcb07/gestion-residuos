<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenSubproducto extends Model
{
    /** @use HasFactory<\Database\Factories\GenSubprodcutoFactory> */
    use HasFactory;

    protected $fillable = [
        'fecha',
        'valor_kg',
        'instituto_id',
        'subproducto_id'
    ];

    // Relacion uno a muchos inversa a nivel de eloquent

    public function instituto()
    {
        return $this->belongsTo(Institutos::class);
    }

    public function subproducto()
    {
        return $this->belongsTo(Subproducto::class);
    }
}
