<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Entities\EndCl;
use App\Entities\ClienteGeolocalizacao;

class GeocodeController extends Controller
{
    public function map(EndCl $endcl, Request $request){
        $clientes =  $endcl
            ->join('Cofema.dbo.ClienteGeolocalizacao', 'ClienteGeolocalizacao.Cli_Cod', '=', 'EndCl.Cli_Cod')
            ->join('Sav.dbo.Clien', 'Clien.Cli_Cod', '=', 'EndCl.Cli_Cod')
            ->select('Clien.Cli_Cod', 'Clien.Cli_Nome', 'Cle_Cep', 'Cle_End', 'Cle_Cidade', 'Cli_Status', 'latitude', 'longitude')
            //->where('cle_cidade', 'Mogi das Cruzes')
            //->where('cle_cep', '<>', '11111111')
            //->whereNotNull('cle_cep')
            //->take(10)
            ->get();
        //return $clientes;
        $cidades = $endcl
            ->select('cle_cidade')
            ->whereIn('cli_cod', function($q) {
                $q
                    ->join('Cofema.dbo.ClienteGeolocalizacao', 'ClienteGeolocalizacao.Cli_Cod', '=', 'Clien.Cli_Cod')
                    ->select('Clien.cli_cod')
                    ->from('Clien');
            })
            //->take(100)
            ->groupby('cle_cidade')
            ->get();

        return view('delivery.index', ['clientes'=>$clientes, 'cidades' => $cidades]);
    }

    public function geocode($cep){
        $url = 'http://maps.google.com/maps/api/geocode/json?address='. $cep .'&sensor=false';
        $geocode = file_get_contents($url);
        $output= json_decode($geocode);

        $lat =$output->results[0]->geometry->location->lat;
        $long = $output->results[0]->geometry->location->lng;
        $end = $output->results[0]->formatted_address;

        echo $end;
        echo "<br />";
        echo $lat;
        echo ", ";
        echo $long;
    }

    public function geocodeClien(EndCl $endcl){
        $cliente_cep =  $endcl
            ->select('cli_cod', 'cle_cep', 'cle_end', 'cle_numero', 'cle_cidade', 'cle_uf')
            //->where('cle_cidade', 'Mogi das Cruzes')
            ->where('cle_cidade', 'Sao Paulo')
            //->where('cli_cod', 334006 )
            //->take(1)
            //->distinct()
            //->where('cli_cod', '<>', 79677 )
            //->whereIn('cli_cod', [1,2,3,4])
            ->whereNotIn('cli_cod', function($q) {
                $q->select('cli_cod')
                    ->from('Cofema.dbo.ClienteGeolocalizacao');
                })
            ->whereIn('cli_cod', function($q) {
                $q->select('cli_cod')
                    ->from('Clien')
                    ->where('Cli_Status', 'O');
            })
            ->orderBy('cli_cod','asc')
            ->get();
        $cont = 0;
        foreach($cliente_cep as $item) {

            //$regra = ['199', 'ã', 'á', 'â', 'é', 'ê', 'õ', 'ó', 'ô', 'í', 'ü'];

            //$item->cle_end = str_replace($regra, '', $item->cle_end);

            $item->cle_end = mb_convert_encoding($item->cle_end, 'UTF-8','UTF-8');

            $item->cle_end = str_replace('?', '', $item->cle_end);

            $item->cle_end = str_replace('S/N', '', str_replace(' ', '+', $item->cle_end));
            $item->cle_cidade = str_replace(' ', '+', $item->cle_cidade);
            $parametros = str_replace(' ', '+', $item->cle_cep . "+" . $item->cle_end . "+" . $item->cle_numero . "+" . $item->cle_cidade . "+" . $item->cle_uf);

            //API Maps para obter retorno de geolocalizacao
            //$url = 'http://maps.google.com/maps/api/geocode/json?address='. $parametros . '&sensor=false';
            $url = 'http://maps.google.com/maps/api/geocode/json?address='. $parametros .'&key=AIzaSyDJOclIKZixJqJgkc5xdtcB5VeByl_2kIw';
            $geocode = file_get_contents($url);
            $output= json_decode($geocode);

            if ($output->status == 'ZERO_RESULTS') {
                continue;
            }

            $lat = $output->results[0]->geometry->location->lat;
            $long = $output->results[0]->geometry->location->lng;

            //Instancia entidade ClienteGeolocalizacao e grava no banco
            $geolocalizacao = new ClienteGeolocalizacao();
            $geolocalizacao->cli_cod = $item->cli_cod;
            $geolocalizacao->latitude = $lat;
            $geolocalizacao->longitude = $long;

            $geolocalizacao->save();

            //echo $cont++ , " - " . $item->cli_cod .' - ' . $parametros . "<br />";
        }
        return 'Gravação Concluída!';

    }

    public function getGeolocalizacao(EndCl $endcl){
        $geolocalizacao =  $endcl
            ->join('Cofema.dbo.Geolocalizacao', 'cep', '=', 'cle_cep')
            ->join('Sav.dbo.Clien', 'Clien.Cli_Cod', '=', 'EndCl.Cli_Cod')
            ->select('Clien.Cli_Cod', 'Clien.Cli_Nome', 'cle_cep', 'cle_end', 'latitude', 'longitude')
            ->where('cle_cidade', 'Mogi das Cruzes')
            ->whereNotNull('cle_cep')
            ->take(10)
            ->get();
        return $geolocalizacao;
    }
    /*
      $this->pedidos
                ->join('Clien', 'Clien.Cli_Cod', '=', 'PdVen.Cli_Cod')
                ->select('PdV_Numero', 'PdVen.Cli_Cod', 'Clien.Cli_Nome', 'PdV_Data', 'statusId')
                ->whereNotIn('statusId', [5, 6, 7, 8, 10])
                ->where('')
                ->get();

     */
}
