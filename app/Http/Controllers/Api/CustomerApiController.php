<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use DB;

class CustomerApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Customer::with('address', 'addresses', 'custattachment')->orderBy('id', 'desc')->paginate(10);

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
            'name' => 'required',
            'branch' => 'required',
            'address'=> 'required',
            'custattachment'=> 'mimes:jpeg,bmp,png,gif,tiff,svg,pdf|max:10240',
        ]);

        $path = $request->file('custattachment')->store('custattachments', 'public');

        DB::beginTransaction();

        $customer = Customer::create($request -> all());
        $customer->address()->create(([
            'description'=>$request->address,
        ]));

        $customer->custattachment()->create(([
            'path'=>$path,
        ]));

        DB::commit();

        return $customer->load('address', 'custattachment');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $customer;
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'branch' => 'required',
            
        ]);

        $customer->name = $request->name;
        $customer->branch = $request->branch;

        $customer->save();

        return $customer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer->delete();
        return $customer;
    }
}
