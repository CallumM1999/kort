<?php

    Route::get('/', 'Base@index');

    Route::get('/dashboard', 'Base@dashboard');

    Route::get('/url/{id}', 'Base@redirectPage');

    Route::any('*', 'Base@notfound');