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

Route::get('/','HomeController@raiz');

Route::get('pdf2', 'ReportController@descargar');
Route::get('pdf', 'ReportController@generar');
Auth::routes();

Route::get('/home', 'HomeController@raiz')->name('home');

Route::get('grafico-userstoday','Graficosyreporte@usersToday');
Route::get('grafico-equipos-deporte','Graficosyreporte@equiposDeporte');

//Route::get('idnoticia/{comment}','CommentController@idnoticia');


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::get('testmongo','PublicacionController@index');

  
    Route::group([
      'middleware' => 'auth'
    ], function() {

        Route::get('elegir','Controller@elegir');

        Route::get('user', 'AuthController@user');

        Route::resource('equipo','EquipoController'); 
        Route::resource('noticia','NoticiaController');

        Route::get('noticias-equipo/{equipo}','EquipoController@noticiasPorEquipo');
        Route::get('equipos-user','EquipoController@equiposPorUsuario');
        Route::get('noticia/crear/{equipo}','NoticiaController@crear')->name('noticia.crear');
        Route::post('noticia/actualizar','NoticiaController@actualizar')->name('noticia.actualizar');
        Route::get('entrenadores/grafica','EquipoController@graficas');
        // rutas para el usuario general

        Route::post('follow','FollowController@store');
        Route::delete('follow/{follow}','FollowController@destroy');
        Route::delete('follow','FollowController@destruir');

        Route::get('follow/{equipo}','FollowController@isFollowed');

        Route::get('publicaciones','PublicacionController@PublicacionesByFollow');
        Route::get('publicacion/{publicacion}','PublicacionController@show');

        //Comentarios 
        Route::post('comment','CommentController@store');
        Route::delete('comment/{comment}','CommentController@destroy');

        Route::get('comment/{idpublicacion}','CommentController@commentByPublicacion'); //obtiene comentarios por id 

        //graficos
        Route::get('grafico-noticias-equipo','Graficosyreporte@noticiasEquipo');

        Route::get('prueba','EquipoController@cont');


        Route::get('ver_equipos','EquipoController@todos');

        //correos
        Route::get('helpmail','HelpMailController@mostrar');
        Route::post('helpmail','HelpMailController@sendHelpMail')->name('mail.send');

        


    });
});



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
