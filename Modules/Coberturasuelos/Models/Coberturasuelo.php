<?php

namespace Modules\Coberturasuelos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Coberturasuelos\Database\Factories\CoberturasueloFactory;

class Coberturasuelo extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    
    protected static function newFactory()
    {
        return CoberturasueloFactory::new();
    }
}
