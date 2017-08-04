<?php



Route::get('/', function () {
    return view('index');
});

#RUTAS DE CLIENTES
Route::get('/clientes/', 'ClienteController@index');

Route::get('/clientes/busqueda/', 'ClienteController@search');

Route::get('/clientes/resultados/', 'ClienteController@results');

Route::get('/clientes/nuevo', 'ClienteController@create');

Route::get('/clientes/{cliente}/editar', 'ClienteController@edit');

Route::get('/clientes/{cliente}', 'ClienteController@show');

Route::post('/clientes', 'ClienteController@store');

Route::patch('/clientes/{cliente}', 'ClienteController@update');

Route::delete('/clientes/{cliente}/destroy', 'ClienteController@destroy');

#RUTAS DE AGENTES
Route::get('/agentes/', 'AgenteController@index');

Route::get('/agentes/busqueda/', 'AgenteController@search');

Route::get('/agentes/resultados/', 'AgenteController@results');

Route::get('/agentes/nuevo', 'AgenteController@create');

Route::get('/agentes/{agente}/editar', 'AgenteController@edit');

Route::get('/agentes/{agente}', 'AgenteController@show');

Route::post('/agentes', 'AgenteController@store');

Route::patch('/agentes/{agente}', 'AgenteController@update');

Route::delete('/agentes/{agente}/destroy', 'AgenteController@destroy');

#RUTAS DE DESTINOS
Route::get('/destinos/', 'DestinoController@index');

Route::get('/destinos/busqueda/', 'DestinoController@search');

Route::get('/destinos/resultados/', 'DestinoController@results');

Route::get('/destinos/nuevo', 'DestinoController@create');

Route::get('/destinos/{agente}/editar', 'DestinoController@edit');

Route::get('/destinos/{agente}', 'DestinoController@show');

#RUTAS DE LINEAS DE TRANSPORTE
// Route::get('/transporte/', 'AgenteController@index');

// Route::get('/transporte/busqueda/', 'AgenteController@search');

// Route::get('/transporte/resultados/', 'AgenteController@results');

// Route::get('/transporte/nuevo', 'AgenteController@create');

// Route::get('/transporte/{agente}/editar', 'AgenteController@edit');

// Route::get('/transporte/{agente}', 'AgenteController@show');

// Route::post('/transporte', 'AgenteController@store');

// Route::patch('/transporte/{agente}', 'AgenteController@update');

// Route::delete('/transporte/{agente}/destroy', 'AgenteController@destroy');

#RUTAS DE VARIOS
Route::get('/varios/', function(){
    return view('pages.varios.index');
});