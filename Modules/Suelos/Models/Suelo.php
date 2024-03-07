<?php

namespace Modules\Suelos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Suelos\Database\Factories\SueloFactory;

class Suelo extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'color'];


    }
