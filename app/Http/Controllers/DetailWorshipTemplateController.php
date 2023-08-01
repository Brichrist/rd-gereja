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
        $DetailWorshipTemplates=DetailWorshipTemplate::where('id_worship_template',$id)->with(['linkActivityTemplate'])->get();
        $arr=DetailWorshipTemplate::where('id_worship_template',$id)->get()->pluck('id_activity_template');
        $ActivityTemplates=ActivityTemplate::where('status','1');
        return view('page.place.detail_index',compact('DetailWorshipTemplates','WorshipPlace','ActivityTemplates','arr'));
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
    public function store($id,Request $request)
    {
        // dd($request->all());
        $index=0;
        DetailWorshipTemplate::where('id_worship_template',$id)->delete();
        foreach ($request->id as $value) {
            DetailWorshipTemplate::create([
                'order'=>$index,
                'id_worship_template'=>$id,
                'id_activity_template'=>$value,
                'done'=>$request->done[$index],
                'default_time'=>$request->default_time[$index],
            ]);
            $index+=1;
        }
        return redirect('/worship-place/'.$id.'/activity');
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
