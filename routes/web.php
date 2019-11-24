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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/leer_admin','HomeController@leer');
Route::get('/estado_admin','HomeController@estado');
Route::get('/cambio_admin','HomeController@cambio_estado');

Route::prefix('docente')->group(function (){
    Route::get('/login','Auth\DocenteLoginController@showLoginForm')->name('docente.login');
    Route::post('/login','Auth\DocenteLoginController@login')->name('docente.login.submit');
    Route::post('logout/', 'Auth\DocenteLoginController@logout')->name('docente.logout');
    Route::get('/', 'DocentesController@index')->name('docente.dashboard');


});
/*datos biometrico*/
Route::get('/GestionBiometricoRegistros','GestionBiometrico\GestionBiometricoController@obtener_registro_biometrico');
Route::get('/GestionBiometricoUsuarios','GestionBiometrico\GestionBiometricoController@obtener_usuarios_biometrico');
Route::get('/GestionUsuarios','GestionBiometrico\GestionBiometricoController@obtener_usuarios');
Route::get('/GestionBiometricologin','GestionBiometrico\GestionBiometricoController@leer_login');
Route::get('/cambio_login','GestionBiometrico\GestionBiometricoController@cambio');
Route::get('/GestionMensaje','GestionBiometrico\GestionBiometricoController@mensaje');

/*RESERVA Y DEVOLUCION DE PROYECTOR(DOCENTE)*/
Route::get('/GestionProyector','GestionProyector\GestionProyectorController@index');
Route::post('/ReservarProyector','GestionProyector\GestionProyectorController@store');
Route::post('/DevolverProyector','GestionProyector\GestionProyectorController@update');
Route::get('/leer','GestionProyector\GestionProyectorController@leer');
Route::get('/estado','GestionProyector\GestionProyectorController@estado');
Route::get('/cambio','GestionProyector\GestionProyectorController@cambio_estado');

/*GESTIO ASISTENCIA (DOCENTE)*/
Route::get('/GestionAsistencia','GestionAsistencia\GestionAsistenciaController@index');

/*dependencia*/
Route::get('Capitulos/{capitulo}','GestionAsistencia\GestionAsistenciaController@dependencia');
Route::get('Tema/{tema}','GestionAsistencia\GestionAsistenciaController@dependenciaTema');
Route::post('/Asistencia','GestionAsistencia\GestionAsistenciaController@store');

/*GESTION DOCENTE (ADMINISTRADOR)*/
Route::get('/GestionDocentes','GestionDocentes\GestionDocentesController@index');
Route::get('/NuevoDocente','GestionDocentes\GestionDocentesController@create');
Route::post('/NuevoDocente','GestionDocentes\GestionDocentesController@store');
Route::get('/EditarDocente/{docente}/edit','GestionDocentes\GestionDocentesController@edit');
Route::put('/EditarDocente/{docente}','GestionDocentes\GestionDocentesController@update');
Route::post('/EliminarDocente/{docente}','GestionDocentes\GestionDocentesController@eliminar');
Route::get('/cambio_docente','GestionDocentes\GestionDocentesController@cambioestado');

Route::get('/GestionCronograma/{docente}','GestionDocentes\GestionCronogramaController@index');
Route::get('/GestionSubirCronograma/{docente}','GestionDocentes\GestionCronogramaController@subir');
Route::post('/import','GestionDocentes\GestionCronogramaController@csv_import')->name('import');
Route::delete('/EliminarCronograma','GestionDocentes\GestionCronogramaController@eliminar_masivo');

Route::get('/Proyectores','GestionDocentes\GestionProyecController@index');
Route::get('/NuevoProyector','GestionDocentes\GestionProyecController@create');
Route::post('/NuevoProyector','GestionDocentes\GestionProyecController@store');
Route::get('/EditarProyector/{proyector}/edit','GestionDocentes\GestionProyecController@edit');
Route::put('/EditarProyector/{proyector}','GestionDocentes\GestionProyecController@update');
Route::post('/EliminarProyector/{proyector}','GestionDocentes\GestionProyecController@eliminar');
Route::get('/CambioEstado','GestionDocentes\GestionProyecController@cambioestado');

Route::get('/GestionPeriodos','GestionDocentes\GestionPeriodosController@index');
Route::get('/NuevoPeriodo','GestionDocentes\GestionPeriodosController@create');
Route::post('/NuevoPeriodo','GestionDocentes\GestionPeriodosController@store');
Route::get('/EditarPeriodo/{periodo}/edit','GestionDocentes\GestionPeriodosController@edit');
Route::put('/EditarPeriodo/{periodo}','GestionDocentes\GestionPeriodosController@update');
Route::delete('/Eliminar/{periodo}','GestionDocentes\GestionPeriodosController@eliminar');

Route::get('buscar/{periodo}/docente/{docente}','GestionDocentes\GestionCronogramaController@buscar');

/*REPORTES*/
Route::get('/ReporteAsistencia','GestionDocentes\GestionReportesController@asistencia');
Route::get('/ReporteProyector','GestionDocentes\GestionReportesController@proyectores');



