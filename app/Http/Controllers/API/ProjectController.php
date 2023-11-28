<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function projects()
    {
        return response()->json([
            'status' => 'success',
            'projects' => Project::with(['type', 'technologies'])->orderByDesc('id')->paginate(9)
        ]);
    }

    public function latest_projects()
    {
        return response()->json([
            'status' => 'success',
            'projects' => Project::with(['type', 'technologies'])->orderByDesc('id')->take(3)->get()
        ]);
    }

    public function single_project($slug)
    {
        $project = Project::with(['type', 'technologies'])->where('slug', $slug)->first();
        if ($project) {
            return response()->json([
                'success' => true,
                'project' => $project
            ]);
        } else {
            return response()->json([
                'success' => false,
                'project' => 'Project not found'
            ]);
        }
    }
}