<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Entities\PdVen as PdVen;

class PedidosSeparadosController extends Controller
{
    private $pedidos;

    public function __construct(PdVen $pedidos){
        $this->pedidos = $pedidos;
    }

    public function pedidosSeparados(){
        /*
        $pedidos =
            $this->pedidos
                ->join('Clien', 'Clien.Cli_Cod', '=', 'PdVen.Cli_Cod')
                ->select('PdV_Numero', 'PdVen.Cli_Cod', 'Clien.Cli_Nome', 'PdV_Data', 'statusId')
                ->whereNotIn('statusId', [5, 6, 7, 8, 10])
                ->where('')
                ->get();
        */
        $pedidos = DB::select("
            select
                B.PdV_Numero,
                D.Cli_Cod,
                D.Cli_Nome,
                B.DataUltimaAlteracao

                from PedidoVendaEntregaLocal A with(nolock)

                inner join PedidoVendaEntrega B with(nolock)
                on B.ID = A.PedidoVendaEntrega

                inner join PdVen C with(nolock)
                on C.PdV_Numero = B.PdV_Numero

                inner join Clien D with(nolock)
                on D.Cli_Cod = C.Cli_Cod

                where
                    A.statusID = 3
                    and C.statusID not in (5, 6, 7, 8, 10)
                    and C.PdV_Cancelado = 'N'

                group by
                    B.PdV_Numero,
                    D.Cli_Cod,
                    D.Cli_Nome,
                    B.DataUltimaAlteracao
                order by B.DataUltimaAlteracao
        ");
        return view('logistica.pedidos_separados', ['pedidos' => $pedidos]);
    }
}
