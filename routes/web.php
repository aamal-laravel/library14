<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
 Route::get('test/{year?}' , function(?int $y = 2000){
    return "The name is: $y";
 })->where('year' , '[0-9]{4}');
 
 Route::get('test/{name}' , function($name){
    return "The name is: $name";
 });