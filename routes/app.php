<?php

use Illuminate\Support\Facades\Route;

Route::get('/produk', function ()
 {
    return view('produk.hello');
});
