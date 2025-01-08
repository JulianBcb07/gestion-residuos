<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Institutos extends Model
{
    /** @use HasFactory<\Database\Factories\InstitutosFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'direccion',
        'logo',
        'telefono',
        'email',
        'sitio_web',
        'meta_anual',
        'total_personas',
    ];

    protected function image(): Attribute
    {
        return new Attribute(
            get: function () {
                // Verificar si la url comienza con https:// o http://
                if ($this->logo) {
                    if (substr($this->logo, 0, 8) === 'https://') {
                        return $this->logo;
                    }

                    return Storage::url($this->logo);
                } else {
                    return asset('src/images/placeholder.jpg');
                }
            }
        );
    }

    // Relacion uno a muchos a nivel eloquent

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function zonas()
    {
        return $this->hasMany(Zona::class);
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }

    public function poblacion()
    {
        return $this->hasMany(PersonaInstituto::class);
    }

    public function percapita()
    {
        return $this->hasMany(PercapitaTotal::class);
    }

    public function genSubproductos()
    {
        return $this->hasMany(GenSubproducto::class);
    }

    // Relacion uno a muchos polimorfica a nivel eloquente entre imagenes e institutos

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
