<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxonomiaSueloCaaguazu extends Model
{
    use HasFactory;

    protected $table = 'tnsue'; // Especifica el nombre de la tabla

    protected $fillable = [
        'orden',
        'desc',
        'id',
        'wkb_geometry',
        'updated_at',// Nombre del campo de geometría
    ];

    // Laravel espera que los campos de fecha/tiempo sean de tipo 'datetime', puedes definirlos como 'null' si no los tienes en tu tabla
    protected $casts = [
        'wkb_geometry' => 'json', // Considerando que 'geometry' es un campo de tipo Geometry, lo casteamos a JSON
    ];
}
