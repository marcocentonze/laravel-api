<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Project;

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

// route tutti i progetti
Route::get('projects', function () {
    $projects = Project::with('type', 'technologies')->OrderbyDesc('id')->paginate(9);
    return response()->json([
        'status' => 'success',
        'result' => $projects
    ]);
});


// route ultimi 3 progetti
Route::get('projects/latest', function () {
    $projects = Project::with('type', 'technologies')->OrderbyDesc('id')->take(3)->get();
    return response()->json([
        'status' => 'success',
        'result' => $projects
    ]);
});

// route singolo progetto
Route::get('projects/{project:slug}', function ($slug) {

    $project = Project::with('type', 'technologies')->where('slug', $slug)->first();

    if ($project) {
        return response()->json([
            'success' => true,
            'result' => $project
        ]);
    } else {
        return response()->json([
            'success' => false,
            'result' => 'Project not found'
        ]);
    }
});
