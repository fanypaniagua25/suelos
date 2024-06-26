<?php

namespace Modules\Propiedades\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Propiedades\Database\Factories\PropiedadeFactory;

class Propiedade extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    
    protected static function newFactory()
    {
        return PropiedadeFactory::new();
    }
}
