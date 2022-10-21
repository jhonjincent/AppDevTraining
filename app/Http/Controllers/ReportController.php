<?php

namespace App\Http\Controllers;

use App\Report;
use App\Comment;
use Illuminate\Http\Request;
use DB;
use Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reports.create');
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
            'title' => 'required',
            'detail' => 'required',
            'department' => 'required',
            'company' => 'required',
            'attachment'=> 'mimes:jpeg,bmp,png,gif,tiff,svg,pdf|max:10240',
        ]);

        Report::create($request->all());
        return redirect()->route('reports.index')
                        ->with('success','Report created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        return view('reports.show',compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        return view('reports.edit',compact('report'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        $request->validate([
            'title' => 'required',
            'detail' => 'required',
            'department' => 'required',
            'company' => 'required',
            'attachment'=> 'mimes:jpeg,bmp,png,gif,tiff,svg,pdf|max:10240',
        ]);
  
        $report->update($request->all());
        return redirect()->route('reports.index')
                        ->with('success','Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('reports.index')
                        ->with('success','Post deleted successfully');
    }

    public function storeowner(Request $request)
    {
        $request -> validate([
            'title' => 'required',
            'detail' => 'required',
            'department' => 'required',
            'company' => 'required',
            'attachment'=> 'mimes:jpeg,bmp,png,gif,tiff,svg,pdf|max:10240',
        ]);

        $path = $request->file('attachment')->store('attachments', 'public');

        DB::beginTransaction();

        $report = Report::create($request -> all());  
        $report->owner()->create(([
            'postedby'=>Auth::user()->id,
            'name'=>$request->owner
        ]));
        $report->attachment()->create(([
            'path'=>$path,
        ]));
        DB::commit();
        return $report->load('attachment');
    }

    public function storecomment(Request $request)
    {
        $request -> validate([
            'com' => 'required',
        ]);

        DB::beginTransaction();

        $report = Report::findOrFail($request->reportId);  
        $report->comment()->create(([
            'commentby'=>Auth::user()->id,
            'com'=>$request->com
        ]));
        DB::commit();
        return $report;
    }
}
