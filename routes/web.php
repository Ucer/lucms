<?php
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('web.logs');
Route::get('/', 'IndexController@index')->name('web.home');
Route::get('/dashboard', 'IndexController@dashboard')->name('web.dashboard');
Route::get('/docs', 'IndexController@docs')->name('web.docs');
