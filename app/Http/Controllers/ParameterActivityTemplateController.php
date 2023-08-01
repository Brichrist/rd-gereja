<?php

namespace App\Http\Controllers;

use App\Models\ParameterActivityTemplate;
use Illuminate\Http\Request;

class ParameterActivityTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $rows=ParameterActivityTemplate::where('id_activity_template',$id)->get();
        return view('page.template.detail_index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        return redirect('/activity-template/'.$id.'/parameter');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ParameterActivityTemplate  $parameterActivityTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(ParameterActivityTemplate $parameterActivityTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ParameterActivityTemplate  $parameterActivityTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(ParameterActivityTemplate $parameterActivityTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ParameterActivityTemplate  $parameterActivityTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$param_id)
    {
        $request->validate([
            'parameter_type' => ['required', 'string'],
            'default_value' => ['required', 'string'],
        ]);
        ParameterActivityTemplate::updateOrCreate(['id' => $param_id],[
            'parameter_type' =>  $request->parameter_type,
            'default_value' => $request->default_value,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect('/activity-template/'.$id.'/parameter');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ParameterActivityTemplate  $parameterActivityTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParameterActivityTemplate $parameterActivityTemplate)
    {
        //
    }
}
