<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = Company::where('status', '=', 1)->paginate(6);
        $result = array();

        foreach ($res as $value) {
            $company = new Company();
            $company = $value;
            $company->user = $value->user->name;
            $company->projects = count($value->projects);
            $result[] = $company;
        }

        return $res;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('companies.create');
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

            $this->validate($request,[
                'name' => 'required|string|max:191',
                'description' => 'required|string|max:191',
            ]);

            return Company::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'user_id' => Auth::user()->id
            ]);

        }

        return back()->withInput()->with('errors', 'U must log in');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        $company = Company::find($company->id);

        return view('companies.show', ['company' => $company]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $company = Company::find($company->id);

        return view('companies.edit', ['company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $companyUpdate = Company::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'description' => 'required|string|max:191',
        ]);
        
        $companyUpdate->update($request->all());

        if ($companyUpdate)
            return ['message', 'Company update with sucessfully'];
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $companyUpdate = Company::where('id', $id)->update([
            'estado' => -1,
        ]);

        if ($companyUpdate) {

            return ['message', 'Company delete sucessfully'];
        }

    }
}
