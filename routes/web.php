<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rutas de login
Auth::routes();

Route::middleware('auth')->group(function () {

  // Reestablecimiento de contraseña
  Route::post('/password/email', ['uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'])->name('password.email');
  Route::get('/password/reset/{token}', ['uses' => 'Auth\ResetPasswordController@showResetForm'])->name('password.reset');
  Route::post('/password/reset', ['uses' => 'Auth\ResetPasswordController@reset'])->name('password.request');

  // 
  Route::get('/home', function () {
    return redirect("/");
  });
  Route::get('/index', function () {
    return redirect("/");
  });

  // Verificar a un usuario
  Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');
  Route::post('/user/verify/{token}', 'Auth\RegisterController@verifyUser');
  Route::get('/', ['as' => 'index', 'uses' => 'HomeController@index']);

  // Usuarios
  Route::resource('usuarios', 'UserController', ["except" => ["create", "edit"]]);

  // Ruta para ver logs
  Route::get('/logs', ['as' => 'logs', 'uses' => 'UserController@verLogs']);

  // Manuales de ayuda al usuario
  Route::get('/ayuda', ['as' => 'ayuda', 'uses' => 'UserController@ayuda']);
  Route::get('/manual', ['as' => 'manual', 'uses' => 'UserController@manuales']);

  //clientes
  Route::resource('clientes', 'ClienteController');
  Route::resource('proveedores', 'ProveedorController');
  Route::resource('servicios', 'ServicioController');

  Route::resource('facturas', 'FacturaController');
  Route::post('/facturas/import', 'FacturaController@import')->name("facturas.import");
  Route::post('/dte/import', 'DTEController@import')->name("dte.import");
  Route::post('/facturas/export', 'FacturaController@export')->name("facturas.export");
  // Route::post('/facturas/exportP', 'FacturaController@export')->name("facturas.exportP");
  Route::resource('pagos', 'PagoController');
  Route::post('/pagos/import', 'PagoController@import')->name("pagos.import");

  Route::resource('entidades', 'EntidadController');
  Route::resource('tipoentidades', 'TipoEntidadController');
  Route::resource('trabajadores', 'TrabajadorController');
  Route::resource('boletasliquidaciones', 'BoletaLiquidacionController');
  Route::resource('gastos', 'GastoController');
});
