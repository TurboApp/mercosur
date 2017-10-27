<?php

Auth::routes();

Route::group( ['middleware' => 'auth' ], function()
{

  Route::get('/', 'inicioController@inicio')->name('inicio');

  // RUTAS MI PERFIL

  Route::get('/perfil/{user}','MiperfilController@show')->name('miPerfil');
  Route::get('/perfil/{user}/editar','MiperfilController@edit')->name('miPerfilEditar');
  Route::patch('/perfil/{user}','MiperfilController@update')->name('miPerfilGuardarCambios');


  #RUTAS DE CLIENTES
  Route::get('/clientes/', 'ClienteController@index')->name('clientes');
  Route::get('/clientes/busqueda/', 'ClienteController@search')->name('clienteBusqueda');
  Route::get('/clientes/nuevo', 'ClienteController@create')->name('clienteNuevo');
  Route::get('/clientes/{cliente}/editar', 'ClienteController@edit')->name('clienteEditar');
  Route::get('/clientes/{cliente}', 'ClienteController@show')->name('cliente');
  Route::post('/clientes', 'ClienteController@store')->name('clienteGuardar');
  Route::patch('/clientes/{cliente}', 'ClienteController@update')->name('clienteGuardarCambios');
  Route::delete('/clientes/{cliente}/destroy', 'ClienteController@destroy')->name('clienteEliminar');

  #RUTAS DE AGENTES

  Route::get('/agentes/', 'AgenteController@index')->name('agentes');
  Route::get('/agentes/busqueda/', 'AgenteController@search')->name('agenteBusqueda');
  Route::get('/agentes/nuevo', 'AgenteController@create')->name('agenteNuevo');
  Route::get('/agentes/{agente}/editar', 'AgenteController@edit')->name('agenteEditar');
  Route::get('/agentes/{agente}', 'AgenteController@show')->name('agente');
  Route::post('/agentes', 'AgenteController@store')->name('agenteGuardar');
  Route::patch('/agentes/{agente}', 'AgenteController@update')->name('agenteGuardarCambios');
  Route::delete('/agentes/{agente}/destroy', 'AgenteController@destroy')->name('agenteEliminar');

  #RUTAS DE TRANSPORTES
  Route::get('/transportes/', 'LineasTransporteController@index')->name('transportes');
  Route::get('/transportes/busqueda/', 'LineasTransporteController@search')->name('transportesBusqueda');
  Route::get('/transportes/nuevo','LineasTransporteController@create')->name('transporteNuevo');
  Route::get('/transportes/{transporte}/editar','LineasTransporteController@edit')->name('transporteEditar');
  Route::get('/transportes/{transporte}','LineasTransporteController@show')->name('transporte');
  Route::post('/transportes','LineasTransporteController@store')->name('transporteGuardar');
  Route::patch('/transportes/{transporte}','LineasTransporteController@update')->name('transporteGuardarCambios');
  Route::delete('/transportes/{transporte}/destroy','LineasTransporteController@destroy')->name('transporteEliminar');
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
  Route::get('/fuerzas/','FuerzaTareaController@index')->name('');
  Route::get('/fuerzas/busqueda/', 'FuerzaTareaController@search');
  Route::get('/fuerzas/nuevo','FuerzaTareaController@create');
  Route::get('/fuerzas/{fuerza}/editar','FuerzaTareaController@edit');
  Route::POST('/fuerzas','FuerzaTareaController@store');
  Route::get('/fuerzas/{fuerza}','FuerzaTareaController@show');
  Route::patch('/fuerzas/{fuerza}','FuerzaTareaController@update');
  Route::delete('/fuerzas/{fuerza}/destroy','FuerzaTareaController@destroy');

  #RUTAS DE TRAFICO
  Route::get('/trafico', 'OrdenServicioController@index')->name('servicios');
  Route::get('/trafico/nuevo', 'OrdenServicioController@createIndex')->name('seleccionarNuevoServicio');
  Route::get('/trafico/nuevo/servicio/{servicio}/{id?}', 'OrdenServicioController@create')->name('servicioNuevo');
  Route::get('/trafico/nuevo/carga/{servicio}', 'OrdenServicioController@createCarga');
  Route::get('/trafico/nuevo/trasbordo', 'OrdenServicioController@createTrasbordo');

  Route::get('/trafico/almacen/', 'OrdenServicioController@indexAlmacen');

  Route::get('/trafico/servicio/{servicio}', 'OrdenServicioController@show');
  Route::post('/trafico/servicio', 'OrdenServicioController@store');
  Route::get('/trafico/coordinacion', 'CoordinacionController@index')->name('coordinacion');

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


  Route::get('/API/agentes/{s?}', 'APIController@agentes');
  Route::get('/API/clientes/{s?}', 'APIController@clientes');
  Route::get('/API/transportes/{s?}', 'APIController@transportes');

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



  

  #RUTAS USUARIOS
  Route::get('/usuarios/','UserController@index');
  Route::get('/usuarios/busqueda/', 'UserController@search');
  Route::get('/usuarios/nuevo','UserController@create');
  Route::post('/usuarios','UserController@store');
  Route::get('/usuarios/{usuario}/editar','UserController@edit');
  Route::patch('/usuarios/{usuario}','UserController@update');
  Route::get('/usuarios/{usuario}','UserController@show');
  Route::delete('/usuarios/{usuario}/destroy','UserController@destroy');

  #RUTAS herramientas
  Route::get('/herramientas/nuevo','ToolController@create');
  Route::post('/herramientas','ToolController@store');
  Route::get('herramientas/puestos','ToolController@get');
  Route::patch('/herramientas/actualizar','ToolController@update');
  Route::get('/herramientas/info-puesto/{puesto}','ToolController@infopuesto');

});
