<?php
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('web.logs');
Route::get('/', 'Controller@index')->name('web.home');
Route::get('/dashboard', 'Controller@dashboard')->name('web.dashboard');
Route::get('/docs', 'Controller@docs')->name('web.docs');
