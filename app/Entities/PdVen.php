<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PdVen extends Model
{
    protected $connection = 'Sav';
    protected $table = 'PdVen';
    protected $primaryKey = 'PdV_Numero';

    protected $fillable = ['PdV_Numero'];
}
