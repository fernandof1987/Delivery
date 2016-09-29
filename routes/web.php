<?php
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return view('home2');
});

Route::get('produtos', 'ProdutosController@index');
Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/home2', function(){
	return view('home2');
});

Route::get('/xnu/arquivos', 'XnuController@listarArquivos');

Route::post('/xnu/upload', 'XnuController@upload');

Route::get('/xnu/lista/{filename}', 'XnuController@listaXnu');

Route::get('/delivery/map', 'GeocodeController@map');
Route::get('/delivery/geocode/{cep}', 'GeocodeController@geocode');
Route::get('/delivery/geocodeclien', 'GeocodeController@geocodeClien');
Route::get('/delivery/geolocalizacao', 'GeocodeController@getGeolocalizacao');

Route::get('/logistica/conferencia', 'PedidosSeparadosController@pedidosSeparados');

Route::get('/soap', function(){
    $wsdl = 'http://cfsp-tothom:8935/WSINTEGSAV.apw?WSDL';
    return phpinfo();
});
