<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'url_image',
        'descripcion',
        'imageable_id',
        'imageable_type'
    ];


    protected function image(): Attribute
    {
        return new Attribute(
            get: function () {
                // Verificar si la url comienza con https:// o http://
                if ($this->url_image) {
                    if (substr($this->url_image, 0, 8) === 'https://') {
                        return $this->url_image;
                    }

                    return Storage::url($this->url_image);
                } else {
                    return asset('src/images/placeholder.jpg');
                }
            }
        );
    }

    // Relacion uno a muchos polimorfica

    public function imageable()
    {
        return $this->morphTo();
    }
}
