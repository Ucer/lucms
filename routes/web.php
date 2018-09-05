<?php
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('/', 'Controller@index');
Route::get('/dashboard', 'Controller@dashboard');
