<?php

    Route::any('/', 'Base@index');
    Route::any('*', 'Base@notfound');