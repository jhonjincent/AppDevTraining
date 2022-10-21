<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Report;
use DB;
use Auth;

class ReportApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Report::with('owner.postedbyinfo', 'attachment', 'comments.commentbyinfo')
            ->orderBy('id', 'desc')
            ->paginate(5);
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

        DB::commit();

        return $report->load('attachment');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $report;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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
        $report->title = $request->title;
        $report->detail = $request->detail;
        $report->department = $request->department;
        $report->company = $request->company;
        $report->attachment = $request->attachment;
        $report->save();
        return $report;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return $report;
    }
}
