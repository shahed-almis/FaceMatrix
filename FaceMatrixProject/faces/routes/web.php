<?php

use App\Models\Face;
use Livewire\Livewire;
use App\Livewire\Faces;
use App\Livewire\Language;
use App\Livewire\AdminComponent;
use App\Livewire\RecognizedFace;
use App\Livewire\ReportComponent;
use App\Livewire\AttendanceTracker;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/livewire/update', $handle);
        });
        Route::group(
            [
                'middleware' => ['auth']
            ],
            function () {

                Route::get('/', Faces::class)->name('home');
                Route::get('/language', Language::class);
                Route::get('/staff', RecognizedFace::class);
                Route::get('/attendance-tracker', AttendanceTracker::class)->name('attendance.tracker');
                Route::get('/reports', ReportComponent::class)->name('reports');
                Route::get('/admins', AdminComponent::class);

                Route::view('profile', 'profile')
                    ->name('profile');
            }
        );

        require __DIR__ . '/auth.php';
    }
);