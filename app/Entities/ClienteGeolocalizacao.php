<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ClienteGeolocalizacao extends Model
{
    protected $connection = 'Cofema';
    protected $table = 'ClienteGeolocalizacao';
    //protected $primaryKey = 'Cle_Cod';

    protected $fillable = ['Cli_Cod', 'Latitude', 'Longitude'];
    public $timestamps = false;
}
