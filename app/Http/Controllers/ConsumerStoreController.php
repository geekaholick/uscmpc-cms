<?php

namespace App\Http\Controllers;

use App\Models\ConsumerStore;
use Illuminate\Http\Request;
use App\Http\Request\ConsumerStoreRequest;

class ConsumerStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->status) {
            $status = ConsumerStore::$STATUS[$request->status];
            $banners = ConsumerStore::where('status', $status)->get();
        }else {
            $banners = ConsumerStore::all();
        }
        return [
            'data' => $banners,
            'success' => true,
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new()
    {   
        
    }

    // public function create(Request $request)zc
    // {
    //     $banner = new ConsumerStore();

    //     $banner->
        
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $banner = ConsumerStore::create($request->all());
            $response['success'] = true;
            $response['message'] = 'Successfully Added!';
            $response['data'] = $banner;
        } catch ( \Exception $e ) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
            $response['data'] =  null;
        }

        return response($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConsumerStore  $consumerStore
     * @return \Illuminate\Http\Response
     */
    public function show(ConsumerStore $consumerStore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConsumerStore  $consumerStore
     * @return \Illuminate\Http\Response
     */
    public function edit(ConsumerStore $consumerStore)
    {
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConsumerStore  $consumerStore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $banner = ConsumerStore::findOrFail($id);
            $banner->update($request->all());
            $response['success'] = true;
            $response['message'] = 'Successfully Updated!';
            $response['data'] = $banner;
        }catch ( \Exception $e ){
            $response['success'] = false;
            $response['message'] = $e->getMessage();
            $response['data'] =  null;
        }
        return response($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConsumerStore  $consumerStore
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $banner = ConsumerStore::findOrFail($request->id);
            $banner->delete();
            $response['success'] = true;
            $response['message'] = 'Successfully Deleted!';
            $response['data'] =  $banner;
        } catch ( \Exception $e ) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
            $response['data'] =  null;
        }

        return response($response);
    }
}
