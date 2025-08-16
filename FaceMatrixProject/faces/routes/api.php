<?php

use App\Models\Face;
use App\Models\Admin;

use App\Livewire\RecognizedFace;
use App\Models\RecognizedFace as ModelsRecognizedFace;
use App\Models\UnrecognizedFaces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::get('/employees', function () {
    $employees = Face::all()->map(function ($employee) {
        $employee->data = $employee->data ? base64_encode($employee->data) : null;
        return $employee;
    });

    return response()->json($employees);
});

Route::get('/admins', function () {
    $admins = Admin::all();
    return response()->json($admins);
});


Route::get('/recognized', function () {
    $reco = ModelsRecognizedFace::with('face')->get()->map(function ($reco) {
        $reco->snapshot = $reco->snapshot ? base64_encode($reco->snapshot) : null;
        return $reco;
    });
    return response()->json($reco);
});

Route::get('/unrecognized', function () {
    $unreco = UnrecognizedFaces::all()->map(function ($unreco) {
        $unreco->snapshot = $unreco->snapshot ? base64_encode($unreco->snapshot) : null;
        return $unreco;
    });
    return response()->json($unreco);
});
