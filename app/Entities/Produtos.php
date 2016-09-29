<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    protected $connection = 'Sav';
    protected $table = 'Produ';
    protected $primaryKey = 'Pro_CodRef';

    protected $fillable = ['Pro_CodRef'];

}
