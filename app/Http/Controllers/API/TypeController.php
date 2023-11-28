<?php

namespace App\Http\Controllers\API;

use App\Models\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function types()
    {
        return response()->json([
            'status' => 'success',
            'types' => Type::with('projects')->orderByDesc('id')->paginate(5)
        ]);
    }
}