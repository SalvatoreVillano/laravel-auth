<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Category;
use App\Models\Tag;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;



class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        if(Auth::user()->isAdmin()){
            $projects = Project::all();
        } else {
            $userId = Auth::id();
            $projects = Project::where('user_id', $userId)->get();
        }
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.projects.create', compact('categories', 'tags'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(StoreProjectRequest $request)
    {
        $userId = Auth::id();
        $data = $request->validated();
        $slug = Project::generateSlug($request->title);
        $data['slug'] = $slug;
        $data['user_id'] = $userId;
        if($request->hasFile('cover_image')){
            $path = Storage::disk('public')->put('project_image', $request->cover_image);
            $data['cover_image'] = $path;
        }
        $newProject = Project::create($data);
        return redirect()->route('admin.projects.show', $newProject->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show(Project $project)
    {
        if(!Auth::user()->isAdmin() && $project->user_id !== Auth::id()){
            abort(403);
        }
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit(Project $project)
    {
        if(!Auth::user()->isAdmin() && $project->user_id !== Auth::id()){
            abort(403);
        }
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.projects.edit', compact('project','categories','tags'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        if(!Auth::user()->isAdmin() && $project->user_id !== Auth::id()){
            abort(403);
        }
        $data = $request->validated();
        $slug = Project::generateSlug($request->title);
        $data['slug'] = $slug;
        $project->update($data);
        return redirect()->route('admin.projects.index')->with('message', "$project->title updated succefully");

    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     */
    public function destroy(Project $project)
    {
        if(!Auth::user()->isAdmin() && $project->user_id !== Auth::id()){
            abort(403);
        }
        $project->delete();
        return redirect()->route('admin.projects.index')->with('message', "$project->title deleted successfully");
    }
}
