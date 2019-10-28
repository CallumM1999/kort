<?php

    Route::redirect('/', '/dashboard');

    Route::get('/dashboard', 'Base@dashboard');

    Route::get('/routes/view/{id}', 'Route');

    Route::get('/routes/add', 'Route@getAdd');
    Route::post('/routes/add', 'Route@postAdd');
    
    Route::get('/routes/edit/{id}', 'Route@getEdit');
    Route::post('/routes/edit/{id}', 'Route@postEdit');

    Route::get('/routes/delete/{id}', 'Route@getDelete');

    Route::get('/page/{id}', 'Page');

    Route::any('*', 'Base@notfound');