<?php

namespace App\Http\Controllers;

use App\Models\DetailWorshipTemplate;
use App\Models\ActivityTemplate;
use App\Models\WorshipPlace;

use Illuminate\Http\Request;

class DetailWorshipTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $WorshipPlace=WorshipPlace::where('id',$id)->first();
        $DetailWorshipTemplates=DetailWorshipTemplate::where('id_worship_template',$id)->get();
        $ActivityTemplates=ActivityTemplate::get();

        return view('page.place.detail_index',compact('DetailWorshipTemplates','WorshipPlace','ActivityTemplates'));
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetailWorshipTemplate  $detailWorshipTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(DetailWorshipTemplate $detailWorshipTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetailWorshipTemplate  $detailWorshipTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailWorshipTemplate $detailWorshipTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DetailWorshipTemplate  $detailWorshipTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailWorshipTemplate $detailWorshipTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailWorshipTemplate  $detailWorshipTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailWorshipTemplate $detailWorshipTemplate)
    {
        //
    }
}
