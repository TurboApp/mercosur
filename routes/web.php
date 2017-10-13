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
Route::get('/API/agentes', 'AgenteController@APIindex');
Route::get('/agentes/busqueda/', 'AgenteController@search');
Route::get('/agentes/nuevo', 'AgenteController@create');
Route::get('/agentes/{agente}/editar', 'AgenteController@edit');
Route::get('/agentes/{agente}', 'AgenteController@show');
Route::post('/agentes', 'AgenteController@store');
Route::patch('/agentes/{agente}', 'AgenteController@update');
Route::delete('/agentes/{agente}/destroy', 'AgenteController@destroy');

#RUTAS DE DESTINOS
// Route::get('/destinos/', 'DestinoController@index');
// Route::get('/destinos/busqueda/', 'DestinoController@search');
// Route::get('/destinos/nuevo', 'DestinoController@create');
// Route::post('/destinos','DestinoController@store');
// Route::get('/destinos/{destino}/editar', 'DestinoController@edit');
// Route::patch('/destinos/{destino}', 'DestinoController@update');
// Route::get('/destinos/{destino}', 'DestinoController@show');
// Route::delete('/destinos/{destino}/destroy','DestinoController@destroy');

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
Route::get('/trafico', 'OrdenServicioController@index');
Route::get('/trafico/nuevo', 'OrdenServicioController@createIndex');

Route::get('/trafico/nuevo/servicio/{servicio}/{id?}', 'OrdenServicioController@create');

Route::get('/trafico/almacen/', 'OrdenServicioController@indexAlmacen');

Route::get('/trafico/nuevo/carga/{servicio}', 'OrdenServicioController@createCarga');
Route::get('/trafico/nuevo/trasbordo', 'OrdenServicioController@createTrasbordo');

Route::get('/trafico/servicio/{servicio}', 'OrdenServicioController@show');

Route::post('/trafico/servicio', 'OrdenServicioController@store');

Route::get('/trafico/coordinacion', 'CoordinacionController@index');

Route::get('/documentos/{id}/{archivo}', 'OrdenServicioController@getArchivo');

Route::get('/API/almacen/item/{servicio}','OrdenServicioController@almacenItem');
Route::get('/API/almacen/{date?}','OrdenServicioController@almacen');
Route::get('/API/servicios/{date?}','OrdenServicioController@indexServicios');
Route::get('/API/coordinacion/{date?}','CoordinacionController@indexDatatable');

#RUTAS DE VARIOS


Route::get('/tipodocumentos','TipoDocumentoController@index');


#Busqueda con sugerencia typeahead

Route::get('/find/cliente', 'SearchController@cliente');
Route::get('/find/destino', 'SearchController@destino');
Route::get('/find/transporte', 'SearchController@transporte');

//  LISTA DE EMPAQUE

// Route::get('/listasempaque/', 'ListasEmpaqueController@index');

// Route::get('/listasempaque/{liastaempaque}', 'ListasEmpaqueController@edit');

// Route::post('/listasempaque', 'ListasEmpaqueController@store');

// Route::put('/listasempaque/{listaempaque}', 'ListasEmpaqueController@update');

// Route::delete('/listasempaque/{listaempaque}/destroy', 'ListasEmpaqueController@destroy');