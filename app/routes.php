<?php

    Route::redirect('/', '/dashboard');

    Route::get('/dashboard', 'Base@dashboard');

    Route::get('/routes/view/{id}', 'Route');

    Route::get('/routes/add', 'Route@getAdd');
    Route::post('/routes/add', 'Route@postAdd');

    // Route::get('/url/{id}', 'Base@redirectPage');

    Route::any('*', 'Base@notfound');