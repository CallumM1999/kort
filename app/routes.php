<?php

    Route::get('/', 'Base');

    Route::get('/login', 'Base@login');
    Route::get('/logout', 'Base@logout');

    Route::get('/dashboard', 'Middleware::auth', 'Base@dashboard');

    Route::get('/routes/view/{id}', 'Middleware::auth', 'Route');

    Route::get('/routes/add', 'Middleware::auth', 'Route@getAdd');
    Route::post('/routes/add', 'Middleware::auth', 'Route@postAdd');
    
    Route::get('/routes/edit/{id}', 'Middleware::auth', 'Route@getEdit');
    Route::post('/routes/edit/{id}', 'Middleware::auth', 'Route@postEdit');

    Route::get('/routes/delete/{id}', 'Middleware::auth', 'Route@getDelete');

    Route::get('/page/{id}', 'Page');

    Route::any('*', 'Base@notfound');