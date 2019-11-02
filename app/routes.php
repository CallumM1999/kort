<?php

    Route::get('/', 'Base');

    Route::get('/login', 'Auth@getLogin');
    Route::post('/login', 'Auth@postLogin');
    Route::get('/register', 'Auth@getRegister');
    Route::post('/register', 'Auth@postRegister');

    Route::get('/account', 'Middleware::auth', 'Auth@account');
    Route::post('/account/delete', 'Middleware::auth', 'Auth@deleteAccount');

    Route::get('/logout', 'Auth@logout');

    Route::get('/routes', 'Middleware::auth', 'Route');

    Route::get('/routes/view/{id}', 'Middleware::auth', 'Route@view');

    Route::get('/routes/add', 'Middleware::auth', 'Route@getAdd');
    Route::post('/routes/add', 'Middleware::auth', 'Route@postAdd');
    
    Route::get('/routes/edit/{id}', 'Middleware::auth', 'Route@getEdit');
    Route::post('/routes/edit/{id}', 'Middleware::auth', 'Route@postEdit');

    Route::get('/routes/delete/{id}', 'Middleware::auth', 'Route@getDelete');

    Route::get('/page/{id}', 'Page');

    Route::any('*', 'Base@notfound');