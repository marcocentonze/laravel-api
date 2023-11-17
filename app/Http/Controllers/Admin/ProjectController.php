<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Type;
use App\Models\Technology;




class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderByDesc('id')->paginate(12);
        return view('admin.posts.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.posts.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {


        // validate the user input
        // $val_data = $request->validate([
        //     'type_id' => 'nullable|exists:types,id',
        //     'title' => 'required|bail|min:3|max:150',
        //     'slug' => 'min:3|max:50',
        //     'description' => 'nullable|max:350',
        //     'cover_image' => 'nullable|image|max:500',
        //     'website_link' => 'nullable|url',
        //     'github_link' => 'nullable|url'
        // ]);

        $val_data = $request->validated();




        // add the cover image if passed in the request
        if ($request->hasFile('cover_image')) {
            $file_path = Storage::disk('public')->put('cover_images', $request->cover_image);
            $val_data['cover_image'] = $file_path;
            // dd($file_path);
        }

        // generate the post slug
        $val_data['slug'] = Str::slug($request->title, '-');




        // create the new article
        $newProject = Project::create($val_data);

        $newProject->technologies()->attach($request->technologies);

        return to_route('admin.projects.index')->with('message', 'Post Created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.posts.show', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $page_title = 'Edit';

        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.posts.edit', compact('project','types','technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $val_data = $request->validated();

        //genera un nuovo slug se è cambiato il titolo
        if (!Str::is($project->getOriginal('title'), $request['title'])) {
            $val_data['slug'] = Str::slug($request->title, '-');
        }

        $val_data = $request->toArray();

        if ($request->hasFile('cover_image')) {
            //salva la nuvoa img
            $file_path = Storage::disk('public')->put('cover_images', $request->cover_image);

            //se project ha già img la cancella e sostituisce
            if ($project->cover_image && Storage::disk('public')->exists($project->cover_image)) {
                Storage::disk('public')->delete($project->cover_image);
            }

            //assegna la nuova img 
            $val_data['cover_image'] = $file_path;
        }

        // dd([$request->toArray(), $project->toArray(), $val_data]);
          
        if ($request->has('technologies')) {
            $project->technologies()->sync($request->technologies); // (o valData['technologies'])
        }
        //update
        $project->update($val_data);


        return to_route('admin.projects.index')->with('message', 'Well Done! Project edited successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {

        $project->delete();

        return to_route('admin.projects.index')->with('message', 'Well Done! Project deleted successfully!');
    }
    public function trashed()
    {
        $trashedProjects = Project::onlyTrashed()->orderByDesc('id')->get();
        return view('admin.posts.trash', compact('trashedProjects'));;
    }

    public function restoreTrash($slug)
    {
        $project = Project::withTrashed()->where('slug', '=', $slug)->first();
        $project->restore();
        return to_route('admin.trash')->with('message', 'Well Done! Project restored successfully!');
    }

    public function forceDestroy($slug)
    {
        $project = Project::withTrashed()->where('slug', '=', $slug)->first();

        $project->technologies()->detach();

        $project->forceDelete();

        return to_route('admin.trash')->with('message', 'Well Done! Project deleted successfully!');
    }
}
