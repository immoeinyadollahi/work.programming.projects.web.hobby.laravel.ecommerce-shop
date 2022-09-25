<?php

use Illuminate\Support\Facades\Route;

use App\Http\Fallback\Controller;

Route::fallback(Controller::class);
