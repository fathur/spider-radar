<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// GET top 10 ip attacker
// GET /ip/attacker
Route::get('ip/attacker/{from?}/{to?}/{count?}', []);

// GET top 10 ip target
Route::get('ip/target/{from?}/{to?}/{count?}', []);

// GET top 10 port attacker
// GET top 10 port target
// GET top 10 protocol attacker
// GET top 10 protocol tar