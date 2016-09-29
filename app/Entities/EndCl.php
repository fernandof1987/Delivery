<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class EndCl extends Model
{
    protected $connection = 'Sav';
    protected $table = 'EndCl';
    protected $primaryKey = 'Cle_Cod';

    protected $fillable = ['cli_cod', 'cle_cep', 'cle_end', 'cle_numero', 'cle_cidade', 'cle_uf'];
}
