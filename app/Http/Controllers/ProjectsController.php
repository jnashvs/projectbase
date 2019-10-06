<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Company;
use Illuminate\Support\Facades\Auth;
use App\Comment;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        return view('projects.index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = NULL)
    {
        if ($id != NULL) {
            $companies = Company::where('user_id', Auth::user()->id)->get();
        }
        return view('projects.create', ['company_id'=>$id, 'companies'=>$companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if (Auth::check()) {

            $project = Project::create([
                'name' => $request->input('name'),
                'days' => $request->input('days'),
                'description' => $request->input('description'),
                'company_id' => $request->input('company_id'),
                'user_id' => Auth::user()->id
            ]);

            if ($project) {
                $company = Company::find($request->input('company_id'));
                return redirect()->route('companies.show', ['company' => $company->id])
                    ->with('success', 'project create sucessfully');
            }
        }

        return back()->withInput()->with('errors', 'U must log in');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //$project = Project::find($project->id);
        $comments = Comment::where('commentable_id', $project->id)->get();

        return view('projects.show', ['project' => $project, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(project $project)
    {
        $project = Project::find($project->id);

        return view('projects.edit', ['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {

        $projectUpdate = Project::where('id', $project->id)->update([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        if ($projectUpdate) {
            return redirect()->route('projects.show', ['project' => $project->id])
                ->with('success', 'project update with sucessfully');
        }

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        /*$projectUpdate = project::where('id', $project->id)->update([
            'status' => -1,
        ]);*/

        if ($projectUpdate=1) {

            return redirect()->route('projects.index')->with('success', 'project delete sucessfully');
        }

        return back()->withInput()->with('error', 'Error while deleting project');
    }
}
