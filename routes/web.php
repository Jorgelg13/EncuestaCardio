<?php
header('Access-Control-Allow-Origin: *');

Route::get('/', function () {
    return view('encuesta');
});

Route::get('/recepcion', function () {
    return view('encuesta_recepcion');
});

Route::get('/encuesta2', function () {
    return view('encuesta2');
});


Route::get('/egreso-hospitalario', function () {
    return view('Egreso-hospitalario');
});

Route::get('/cabina', function () {
    return view('encuesta_cabina');
});


Route::get('/codoReclamo', "PdfController@codoReclamo");


Route::prefix('/api/v1/')->group(function () {
    Route::post('encuesta/guardar', 'EncuestaController@guardar');

    Route::post('envioColectivos/{id}', 'ColectivoController@envioColectivos');
    Route::get('verPdf/{id}', 'ColectivoController@verPdf');

    Route::post('bcs/memo/{tipo}', 'MemoController@demo');
    Route::post('bcs/demo/memo', 'MemoController@demo');
});

header('Access-Control-Allow-Origin: *');