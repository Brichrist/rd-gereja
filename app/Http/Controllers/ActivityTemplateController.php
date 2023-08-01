<?php

namespace App\Http\Controllers;

use App\Models\ActivityTemplate;
use App\Models\ParameterActivityTemplate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ActivityTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = ActivityTemplate::with(['linkParameterActivityTemplate'])->get();

        return view('page.template.index', compact('rows'));
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
    public function store(Request $request)
    {
        $request->validate([
            'activity' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string'],
            'default_time' => ['nullable', 'numeric'],
            'done' => ['required', 'string'],
            'type' => ['required', 'string'],
            'status' => ['required', 'string'],
        ]);
        $data=ActivityTemplate::create([
            'activity' => $request->activity,
            'value' => $request->value,
            'default_time' => $request->default_time,
            'done' =>  $request->done,
            'type' =>  $request->type,
            'status' =>  $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $keys=[];
        foreach (explode("{", $request->value) as $key) {
            if (str_contains($key,"}")) {
                $keys[]=explode("}", $key)[0];
            }
        }
        foreach ($keys as $key ) {
            ParameterActivityTemplate::create([
                'id_activity_template' =>  $data->id,
                'parameter_key' => $key,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return redirect('/activity-template');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ActivityTemplate  $activityTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(ActivityTemplate $activityTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ActivityTemplate  $activityTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivityTemplate $activityTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivityTemplate  $activityTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        session()->flash('is', $id);
        // dd($id);
        $request->validate([
            'activity' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string'],
            'default_time' => ['nullable', 'numeric'],
            'done' => ['required', 'string'],
            'type' => ['required', 'string'],
            'status' => ['required', 'string'],
        ]);
        ActivityTemplate::updateOrCreate([
            'id' => $id,
        ],[
            'activity' => $request->activity,
            'value' => $request->value,
            'default_time' => $request->default_time,
            'done' =>  $request->done,
            'type' =>  $request->type,
            'status' =>  $request->status,
            'updated_at' => now(),
        ]);
        ParameterActivityTemplate::where('id_activity_template',$id)->delete();
        
        $keys=[];
        foreach (explode("{", $request->value) as $key) {
            if (str_contains($key,"}")) {
                $keys[]=explode("}", $key)[0];
            }
        }
        foreach ($keys as $key ) {
            ParameterActivityTemplate::create([
                'id_activity_template' =>  $id,
                'parameter_key' => $key,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('/activity-template');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ActivityTemplate  $activityTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivityTemplate $activityTemplate)
    {
        //
    }
}
