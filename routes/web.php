<?php

Auth::routes();

Route::group( ['middleware' => 'auth' ], function()
{

  Route::get('/', 'inicioController@inicio')->name('inicio');
  Route::get('/error/503','inicioController@error');

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
  Route::get('/clientes/{cliente}/metricas', 'ClienteController@metrica')->name('clienteMetrica');
  Route::delete('/clientes/{cliente}/destroy', 'ClienteController@destroy')->name('clienteEliminar');
  Route::get('/clientes/API/{cliente}', 'ClienteController@APImetrica');

  #RUTAS DE AGENTES

  Route::get('/agentes/', 'AgenteController@index')->name('agentes');
  Route::get('/agentes/busqueda/', 'AgenteController@search')->name('agenteBusqueda');
  Route::get('/agentes/nuevo', 'AgenteController@create')->name('agenteNuevo');
  Route::get('/agentes/{agente}/editar', 'AgenteController@edit')->name('agenteEditar');
  Route::get('/agentes/{agente}/metricas', 'AgenteController@metrica')->name('agenteMetrica');
  Route::get('/agentes/API/{agente}', 'AgenteController@APImetrica');

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
  Route::get('/transportes/{transporte}/metricas', 'LineasTransporteController@metrica')->name('transporteMetrica');
  Route::get('/transportes/API/{transporte}', 'LineasTransporteController@APImetrica');
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

  // RUTA DE PRODUCCION OPERARIOS (PERFIL GERENTE OPERATIVO)
  Route::get('/operarios-produccion/','FuerzaTareaController@operariosProduccion')->name('operarios-produccion');
  Route::get('/operarios-produccion/activos','FuerzaTareaController@operariosProduccionActivos')->name('operarios-produccion-activos');
  Route::get('/operarios-produccion/inactivos','FuerzaTareaController@operariosProduccionInactivos')->name('operarios-produccion-inactivos');

  Route::get('/operarios-produccion/busqueda/', 'FuerzaTareaController@searchOperariosProduccion');
  Route::get('/operarios-produccion/API/{operario}/{date?}','FuerzaTareaController@getDataOperario');
  Route::get('/operarios-produccion/{operario}','FuerzaTareaController@showOperario');

  Route::get('/supervisores/','FuerzaTareaController@supervisoresProduccion')->name('supervisores');
  Route::get('/supervisores/busqueda/', 'FuerzaTareaController@searchSupervisoresProduccion');
  Route::get('/supervisores/API/{supervisor}/{date?}','FuerzaTareaController@getDataSupervisor');
  Route::get('/supervisores/{supervisor}','userController@showSupervisor');
  Route::get('/supervisores/{supervisor}/metricas','FuerzaTareaController@showSupervisor');

  Route::get('/coordinadores/','FuerzaTareaController@coordinadoresProduccion')->name('coordinadores');
  Route::get('/coordinadores/busqueda/', 'FuerzaTareaController@searchCoordinadoresProduccion');
  Route::get('/coordinadores/API/{coordinador}/{date?}','FuerzaTareaController@getDataCoordinador');
  Route::get('/coordinadores/{coordinador}','userController@showCoordinador');
  Route::get('/coordinadores/{coordinador}/metricas','FuerzaTareaController@showCoordinador');





  // RUTAS DE FUERZA DE TAREA
  Route::get('/fuerzas/','FuerzaTareaController@index')->name('fuerza-tarea');
  Route::get('/fuerzas/busqueda/', 'FuerzaTareaController@search');
  Route::get('/fuerzas/nuevo','FuerzaTareaController@create');
  Route::get('/fuerzas/{fuerza}/editar','FuerzaTareaController@edit');
  Route::POST('/fuerzas','FuerzaTareaController@store');
  Route::get('/fuerzas/{fuerza}','FuerzaTareaController@show');
  Route::patch('/fuerzas/{fuerza}','FuerzaTareaController@update');
  Route::delete('/fuerzas/{fuerza}/destroy','FuerzaTareaController@destroy');

  #RUTAS DE TRAFICO / SERVICIOS
  Route::get('/servicios', 'ServicioController@index')->name('servicios');
  Route::get('/servicios/nuevo', 'ServicioController@new')->name('servicioNuevo');
  Route::get('/servicios/nuevo/{servicio}/{id?}', 'ServicioController@create')->name('servicioCrear');
  Route::get('/servicios/team/{equipo}', 'ServicioController@indexEquipo')->name('serviciosEquipo');
  Route::post('/servicios', 'ServicioController@store')->name('servicioGuardar');
  Route::get('/servicios/{servicio}', 'ServicioController@show');
  Route::get('/servicios/{servicio}/editar', 'ServicioController@edit');
  Route::get('/servicios/{servicio}/editarProductividad', 'ServicioController@editProductividad');
  Route::get('/servicios/detalles/{servicio}', 'CoordinacionController@maniobra');

  Route::get('/almacen', 'ServicioController@almacen');

  Route::get('/coordinacion', 'CoordinacionController@index')->name('coordinacion');
  Route::get('/coordinacion/servicio/{servicio}/', 'CoordinacionController@maniobra');
  Route::post('/coordinacion/maniobra/inicio/{servicio}/', 'CoordinacionController@maniobraInicio');
  Route::post('/coordinacion/maniobra/fin/{servicio}/', 'CoordinacionController@maniobraFin');

  Route::get('/maniobras/', 'CoordinacionController@indexManiobra')->name('maniobras');
  Route::get('/maniobras/{coordinacion}/', 'CoordinacionController@maniobraTareas');


  Route::get('/maniobra/tarea/{id}','TareaController@getTarea');

  Route::post('/maniobra/tarea/{option}/{tareaId}', 'TareaController@tareaTimer');
  Route::post('/maniobra/subtarea/{id}','TareaController@storeSubtarea');
  Route::get('/maniobra/subtarea/firma/{tarea_id}/{subtarea}','TareaController@getSignature');
  Route::get('/signatures/{signature}','TareaController@getFileSignature');

  Route::get('/maniobra/subtarea/photos/{photo}','TareaController@getPhotos');

  Route::get('/maniobra/operarios/{s?}','TareaController@getOperarios');
  Route::get('/maniobra/operariosActivos/{coordinacionid}','TareaController@getOperariosActivos');
  Route::get('/maniobras_attachment/{a}/{m}/{d}/{photo}', 'TareaController@getFilePhoto');


  Route::delete('/maniobras/subtarea/{id}/destroy','TareaController@destroySubtarea');
  Route::patch('/maniobras/fuerza-tarea/status/{id}/{coordinacion}','TareaController@updateFuerzaTarea');
  

  Route::post('/maniobras/produccion/inicar/{coordinacion}/','TareaController@activarProduccionFuerzaTarea');
  Route::post('/maniobras/produccion/{coordinacion}/{operario}','TareaController@updateProduccionFuerzaTarea');
  Route::get('/maniobras/fuerzaTarea/free/{coordinacion}', 'TareaController@liberarFuerzaTarea');
  
  Route::post('/maniobra/avance/update/{maniobra}/{avance}/{activeIndex}', 'CoordinacionController@updateAvanceManiobra');


  Route::post('/procesoManiobraFin/{servicio}', 'CoordinacionController@procesoFinManiobra');
  Route::post('/proceso-maniobra/{servicio}/{tarea}/{index}', 'CoordinacionController@procesoManiobra');
  //Route::post('/maniobra/tarea/inicio/','');

  Route::get('/documentos/{id}/{archivo}', 'ServicioController@getArchivo');

  // Route::get('/trafico', 'OrdenServicioController@index')->name('servicioTrafico');
  // Route::get('/trafico/nuevo', 'OrdenServicioController@createIndex')->name('seleccionarNuevoServicio');
  // Route::get('/trafico/nuevo/carga/{servicio}', 'OrdenServicioController@createCarga');
  // Route::get('/trafico/nuevo/trasbordo', 'OrdenServicioController@createTrasbordo');
  // Route::get('/trafico/almacen/', 'OrdenServicioController@indexAlmacen');
  // Route::get('/trafico/servicio/{servicio}', 'OrdenServicioController@show');
  // Route::post('/trafico/servicio', 'OrdenServicioController@store');


  //Route::get('/documentos/{id}/{archivo}', 'OrdenServicioController@getArchivo');
  // Route::get('/API/servicios/{date?}','OrdenServicioController@indexServicios');
  // Route::get('/API/coordinacion/{date?}','CoordinacionController@indexDatatable');
  // Route::get('/API/almacen/item/{servicio}','OrdenServicioController@almacenItem');
  // Route::get('/API/almacen/{date?}','OrdenServicioController@almacen');

  Route::get('/notificaciones/', 'NotificationController@index');
  Route::get('/notificaciones/loadMore/','NotificationController@loadMore');
  Route::get('/notificaciones/readed/','NotificationController@readed');
  Route::get('/notificaciones/unread/','NotificationController@unread');
  Route::get('/notificaciones/readedAll/','NotificationController@readedAll');
  
  #API

  Route::get('/API/auth/', 'APIController@auth');

  Route::get('/API/agentes/{s?}', 'APIController@agentes');
  Route::get('/API/clientes/{s?}', 'APIController@clientes');
  Route::get('/API/transportes/{s?}', 'APIController@transportes');

  Route::get('/API/servicios/{date?}','APIController@servicios');
  Route::get('/API/maniobras/{date?}/{equipo?}','APIController@maniobras');
  Route::get('/API/coordinacion/{date?}','APIController@coordinacion');
  //Route::get('/API/coordinacion/')

  Route::get('/API/maniobra-supervisor/{date?}','APIController@maniobrasSupervisor');

  Route::get('/API/coordinacion/servicio/{id}','APIController@coordinacionServicio');
  Route::get('/API/coordinacion/servicio/agregar_supervisor/{coordinacion}/{supervisor}','APIController@agregarSupervisor');
  Route::get('/API/almacen/item/{servicio}','APIController@almacenItem');
  Route::get('/API/almacen/{date?}','APIController@almacen');
  Route::get('/API/supervisores/{s?}','APIController@supervisores');
  Route::get('/API/supervisor/{id}', 'APIController@supervisor');
  Route::get('/API/info-user/{user}','APIController@infoUser');

  Route::get('/API/supervision/getTareas/{id}', 'APIController@getTareas');
  Route::get('/API/supervision/getSubTareas/{id}', 'APIController@getSubTareas');

  #Busqueda con sugerencia typeahead

  Route::get('/find/cliente', 'SearchController@cliente');
  Route::get('/find/destino', 'SearchController@destino');
  Route::get('/find/transporte', 'SearchController@transporte');


  #Rutas creacion de PDF
  Route::get('/pdf/{servicio}/{tipo}','PdfController@previo');

  #Rutas Notificacion
  Route::get('/notificaciones/','NotificationController@index');

  #RUTAS USUARIOS
  Route::get('/usuarios/','UserController@index')->name('usuarios');
  Route::get('/usuarios/busqueda/', 'UserController@search');
  Route::get('/usuarios/nuevo','UserController@create');
  Route::post('/usuarios','UserController@store');
  Route::get('/usuarios/{usuario}/editar','UserController@edit');
  Route::patch('/usuarios/{usuario}','UserController@update');
  Route::get('/usuarios/{usuario}','UserController@show');
  Route::delete('/usuarios/{usuario}/destroy','UserController@destroy');

  #RUTAS herramientas
  Route::get('/herramientas/puestos','PuestoController@createPuesto');
  Route::post('/herramientas/puestos/nuevo','PuestoController@storePuesto');
  Route::get('/herramientas/getPuestos','PuestoController@get');
  Route::post('/herramientas/puestos/edit','PuestoController@update');
  Route::get('/herramientas/info-puesto/{puesto}','PuestoController@infopuesto');

  Route::get('/herramientas/equipos','EquipoController@createEquipo')->name('equipos');
  Route::get('/herramientas/equipos/detalles/{id}','EquipoController@showEquipo');
  Route::post('/herramientas/equipos/nuevo','EquipoController@storeEquipo');
  Route::get('/herramientas/equipos/info/{id}','EquipoController@infoEquipo');
  Route::post('/herramientas/equipos/update', 'EquipoController@updateEquipo');


});
