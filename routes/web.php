<?php

Auth::routes();

Route::group(['middleware'=>'auth'],function(){
  Route::get('/', function () {
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

  // RUTAS DE FUERZA DE TAREA
  Route::get('/fuerzas/','FuerzaTareaController@index');

  Route::get('/fuerzas/nuevo','FuerzaTareaController@create');

  Route::get('/fuerzas/{fuerza}/editar','FuerzaTareaController@edit');

  Route::POST('/fuerzas','FuerzaTareaController@store');

  Route::get('/fuerzas/{fuerza}','FuerzaTareaController@show');

  Route::patch('/fuerzas/{fuerza}','FuerzaTareaController@update');

  Route::delete('/fuerzas/{fuerza}/destroy','FuerzaTareaController@destroy');

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


}
);

Route::get('/home', 'HomeController@index')->name('home');
