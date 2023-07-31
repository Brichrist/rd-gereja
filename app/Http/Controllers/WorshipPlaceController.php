<?php

namespace App\Http\Controllers;

use App\Models\WorshipPlace;
use Illuminate\Http\Request;

class WorshipPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = WorshipPlace::get();

        return view('page.place.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'name' => ['required', 'string', 'max:255'],
            'time_start' => ['required', 'date_format:H:i'],
            'time_end' => ['required', 'date_format:H:i'],
            'status' => ['required', 'string']
        ]);
        WorshipPlace::create([
            'name' => $request->name,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'status' =>  $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect('/worship-place');

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorshipPlace  $worshipPlace
     * @return \Illuminate\Http\Response
     */
    public function show(WorshipPlace $worshipPlace)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorshipPlace  $worshipPlace
     * @return \Illuminate\Http\Response
     */
    public function edit(WorshipPlace $worshipPlace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorshipPlace  $worshipPlace
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        session()->flash('is', $id);
        // dd($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'time_start' => ['required', 'date_format:H:i'],
            'time_end' => ['required', 'date_format:H:i'],
            'status' => ['required', 'string']
        ]);
        WorshipPlace::updateOrCreate([
            'id' => $id,
        ],[
            'name' => $request->name,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'status' =>  $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect('/worship-place');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorshipPlace  $worshipPlace
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorshipPlace $worshipPlace)
    {
        //
    }
}
