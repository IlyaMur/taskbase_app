<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProjectRequest;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->accessibleProjects();

        dd($projects);

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);

        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }

    public function create()
    {
        return view('projects.create', ['project' => new Project()]);
    }

    public function update(Project $project)
    {
        $attributes = request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);

        $project->update($attributes);

        return redirect(($project->path()));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }
}
