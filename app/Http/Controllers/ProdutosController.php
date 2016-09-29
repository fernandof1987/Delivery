<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Entities\Produtos as Produtos;

class ProdutosController extends Controller
{
    public function index(){
    	//echo '<iframe frameborder="0" src="https://analytics.totvs.com.br/dashboard.html#project=/gdc/projects/eg9qka53on9u19oc7wmkbqpgusqnsvn6&dashboard=/gdc/md/eg9qka53on9u19oc7wmkbqpgusqnsvn6/obj/14335" width="100%" height="1120px" allowTransparency="false"></iframe>';
    	echo Produtos::all()->take(30);
    }
}
