<?php


namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;

class TechnologyController extends Controller
{


    public function technologies()
    {
        return response()->json([
            'status' => 'success',
            'technologies' => Technology::with('projects')->get()
        ]);
    }

    public function technology_projects($slug)
    {
        $projects = Technology::with(['projects'])->where('slug', $slug)->first()->projects()->with(['technologies', 'type'])->paginate(8);
    
        return response()->json([
            'status' => 'success',
            'technologies' => $projects
        ]);
    }
}
