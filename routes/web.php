<?php



Route::get('/', function () {
    return view('index');
});

#RUTAS DE CLIENTES
Route::get('/clientes/', 'ClienteController@index');

Route::get('/clientes/busqueda/', 'ClienteController@search');

Route::get('/clientes/nuevo', 'ClienteController@create');

Route::get('/clientes/{cliente}/editar', 'ClienteController@edit');

Route::get('/clientes/{cliente}', 'ClienteController@show');

Route::post('/clientes', 'ClienteController@store');

Route::patch('/clientes/{cliente}', 'ClienteController@update');

Route::delete('/clientes/{cliente}/destroy', 'ClienteController@destroy');

#RUTAS DE AGENTES
Route::get('/agentes/', 'AgenteController@index');

Route::get('/agentes/busqueda/', 'AgenteController@search');

Route::get('/agentes/nuevo', 'AgenteController@create');

Route::get('/agentes/{agente}/editar', 'AgenteController@edit');

Route::get('/agentes/{agente}', 'AgenteController@show');

Route::post('/agentes', 'AgenteController@store');

Route::patch('/agentes/{agente}', 'AgenteController@update');

Route::delete('/agentes/{agente}/destroy', 'AgenteController@destroy');

#RUTAS DE DESTINOS
Route::get('/destinos/', 'DestinoController@index');

Route::get('/destinos/busqueda/', 'DestinoController@search');

Route::get('/destinos/nuevo', 'DestinoController@create');

Route::post('/destinos','DestinoController@store');

Route::get('/destinos/{destino}/editar', 'DestinoController@edit');

Route::patch('/destinos/{destino}', 'DestinoController@update');

Route::get('/destinos/{destino}', 'DestinoController@show');

Route::delete('/destinos/{destino}/destroy','DestinoController@destroy');

#RUTAS DE TRANSPORTES
Route::get('/transportes/', 'LineasTransporteController@index');

Route::get('/transportes/busqueda/', 'LineasTransporteController@search');

Route::get('/transportes/nuevo','LineasTransporteController@create');

Route::post('/transportes','LineasTransporteController@store');

Route::get('/transportes/{transporte}','LineasTransporteController@show');

Route::get('/transportes/{transporte}/editar','LineasTransporteController@edit');

Route::patch('/transportes/{transporte}','LineasTransporteController@update');

Route::delete('/transportes/{transporte}/destroy','LineasTransporteController@destroy');

#RUTAS DE TRAFICO

Route::get('/traficos/nuevo', 'OrdenServicioController@create');


#RUTAS DE VARIOS
Route::get('/varios/', function(){
    return view('pages.varios.index');
});

Route::get('/tipodocumentos','TipoDocumentoController@index');