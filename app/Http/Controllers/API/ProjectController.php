<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function projects(Request $request)
    {
        $query = Project::with(['type', 'technologies']);

        // Verifica se è stato fornito un parametro di query 'technology' e non è 'all'
        if ($request->has('technology') && $request->technology != 'all') {
            // Aggiungi una condizione alla query per filtrare i progetti in base alla tecnologia
            $query->whereHas('technologies', function ($q) use ($request) {
                // Assicurati che il campo utilizzato qui corrisponda a quello nel tuo database
                $q->where('name', $request->technology);
            });
        }

        // Ottieni i progetti filtrati (se applicabile) e paginati
        $projects = $query->orderByDesc('id')->paginate(9);

        return response()->json([
            'status' => 'success',
            'projects' => $projects
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
