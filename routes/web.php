<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::patch('todos/{todo}/toggle', [TodoController::class, 'toggle'])->name('todos.toggle');

Route::resource('todos', TodoController::class);

Route::redirect('/', '/todos');
