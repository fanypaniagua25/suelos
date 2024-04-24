<?php

namespace Modules\Cultivos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cultivos\Database\Factories\CultivoFactory;

class Cultivo extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    
    protected static function newFactory()
    {
        return CultivoFactory::new();
    }
}
