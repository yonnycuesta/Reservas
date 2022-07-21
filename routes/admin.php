<?php

use Illuminate\Support\Facades\Route;


Route::view('services', 'services')->name('home');
Route::view('customers', 'customers')->name('home');
Route::view('employees', 'employees')->name('home');
Route::view('schedules', 'schedules')->name('home');
Route::view('innings', 'innings')->name('home');
Route::view('service-employee', 'service-employee');
