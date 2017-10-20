<?php

Auth::routes();

Route::group( ['middleware' => 'auth' ], function()
{
  Route::get('/', function () 
  {
      return view('index');
  });

  // RUTAS MI PERFIL

  Route::get('/perfil/{user}','MiperfilController@index');


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
  // Route::get('/API/agentes', 'AgenteController@APIindex');
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
  
  // RUTAS DE FUERZA DE TAREA
  Route::get('/fuerzas/','FuerzaTareaController@index');
  Route::get('/fuerzas/nuevo','FuerzaTareaController@create');
  Route::get('/fuerzas/{fuerza}/editar','FuerzaTareaController@edit');
  Route::POST('/fuerzas','FuerzaTareaController@store');
  Route::get('/fuerzas/{fuerza}','FuerzaTareaController@show');
  Route::patch('/fuerzas/{fuerza}','FuerzaTareaController@update');
  Route::delete('/fuerzas/{fuerza}/destroy','FuerzaTareaController@destroy');
  
  #RUTAS DE TRAFICO
  Route::get('/trafico', 'OrdenServicioController@index');
  Route::get('/trafico/nuevo', 'OrdenServicioController@createIndex');
  Route::get('/trafico/nuevo/servicio/{servicio}/{id?}', 'OrdenServicioController@create');
  Route::get('/trafico/nuevo/carga/{servicio}', 'OrdenServicioController@createCarga');
  Route::get('/trafico/nuevo/trasbordo', 'OrdenServicioController@createTrasbordo');
  
  Route::get('/trafico/almacen/', 'OrdenServicioController@indexAlmacen');
  
  Route::get('/trafico/servicio/{servicio}', 'OrdenServicioController@show');
  Route::post('/trafico/servicio', 'OrdenServicioController@store');
  Route::get('/trafico/coordinacion', 'CoordinacionController@index');
  

  Route::get('/trafico/maniobra/{servicio}/detalles', 'CoordinacionController@maniobraDetalles');
  Route::get('/trafico/maniobra/{servicio}/datos_generales', 'CoordinacionController@maniobraGenerales');
  Route::get('/trafico/maniobra/{servicio}/transportes', 'CoordinacionController@maniobraTransportes');
  Route::get('/trafico/maniobra/{servicio}/documentos', 'CoordinacionController@maniobraDocumentos');
  Route::get('/trafico/maniobra/{servicio}/archivos', 'CoordinacionController@maniobraArchivos');
  Route::get('/trafico/maniobra/agregar_supervisor/{coordinacion}/{supervisor}', 'CoordinacionController@agregarSupervisor');
  
  Route::get('/documentos/{id}/{archivo}', 'OrdenServicioController@getArchivo');
  // Route::get('/API/servicios/{date?}','OrdenServicioController@indexServicios');
  // Route::get('/API/coordinacion/{date?}','CoordinacionController@indexDatatable');
  // Route::get('/API/almacen/item/{servicio}','OrdenServicioController@almacenItem');
  // Route::get('/API/almacen/{date?}','OrdenServicioController@almacen');
  
  #API
  
  
  Route::get('/API/agentes', 'APIController@agentes');
  Route::get('/API/servicios/{date?}','APIController@servicios');
  Route::get('/API/coordinacion/{date?}','APIController@coordinacion');
  Route::get('/API/almacen/item/{servicio}','APIController@almacenItem');
  Route::get('/API/almacen/{date?}','APIController@almacen');
  Route::get('/API/supervisores/{s?}','APIController@supervisores');
  Route::get('/API/info-user/{user}','APIController@infoUser');
  

  #Busqueda con sugerencia typeahead

  Route::get('/find/cliente', 'SearchController@cliente');
  Route::get('/find/destino', 'SearchController@destino');
  Route::get('/find/transporte', 'SearchController@transporte');



  #RUTAS DE TRANSPORTES
  Route::get('/transportes/', 'LineasTransporteController@index');
  Route::get('/transportes/busqueda/', 'LineasTransporteController@search');
  Route::get('/transportes/nuevo','LineasTransporteController@create');
  Route::post('/transportes','LineasTransporteController@store');
  Route::get('/transportes/{transporte}/editar','LineasTransporteController@edit');
  Route::patch('/transportes/{transporte}','LineasTransporteController@update');
  Route::get('/transportes/{transporte}','LineasTransporteController@show');
  Route::delete('/transportes/{transporte}/destroy','LineasTransporteController@destroy');

  #RUTAS USUARIOS
  Route::get('/usuarios/','UserController@index');
  Route::get('/usuarios/nuevo','UserController@create');
  Route::post('/usuarios','UserController@store');
  Route::get('/usuarios/{usuario}/editar','UserController@edit');
  Route::patch('/usuarios/{usuario}','UserController@update');
  Route::get('/usuarios/{usuario}','UserController@show');
  Route::delete('/usuarios/{usuario}/destroy','UserController@destroy');

  #RUTAS herramientas
  Route::get('/herramientas/','ToolController@index');
  Route::get('/herramientas/nuevo','ToolController@create');
  Route::post('/herramientas','ToolController@store');


});


