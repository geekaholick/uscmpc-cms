<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtherServices;
use App\Http\Requests\OtherServicesRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OtherServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $status = isset(request()->status) || 0;
        // $otherServices = OtherServices::where('status', OtherServices::$STATUS[$status])
        //                         ->get();
        return OtherServices::orderBy('created_at', 'desc')->get();
        return response([
            'success' => true,
            'data'    => $otherServices,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(OtherServicesRequest $request)
    {
        if (!$request->validateData()[0]) {
            $response['success'] = false;
            $response['status']  = 200;
            $response['data']    = $request->validateData()[1];
            return response($response, $response['status']);
        }
        DB::beginTransaction();
        $response = [];

        // $validator = Validator::make($request->all(), [
        //     'title'=>'required',
        //     'description'=>'required',
        //     'image'=>'sometimes',
        //     'icon'=>'sometimes',
        // ]);
        // $validated = $validator->validated(); 

        $otherServices = new OtherServices();
        $otherServices->title = $request->title;
        $otherServices->description = $request->description;
        $otherServices->icon = $request->icon;
        $otherServices->status = 1;
        
        if ($request->hasfile('image')) {
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('service', $imageName);

            $otherServices->image = $imageName;

        }
        // $data = $request->all();
        try{
            $otherServices->save();
            // $otherServices = OtherServices::create($data);
            DB::commit();

            $response['success'] = true;
            $response['status']  = 200;
            $response['message'] = 'Successfully created!';
            $response['data']    = $otherServices;
        } catch ( \Exception $e ) {
            DB::rollback();
            $response['success']  = false;
            $response['status']   = 200;
            $response['message']  = 'Failed to create Service! | Error: '.$e->getMessage();
            $response['data']     = null;
        }

        // $response = [
        //     'message' => "Service Successfully Added",
        //     'status'=> 200
        // ];

        return response($response, $response['status']);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(sRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OtherServices  $otherServices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return OtherServices::find($id);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OtherServices  $otherServices
     * @return \Illuminate\Http\Response
     */
    public function edit(OtherServicesRequest $otherServices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OtherServices  $otherServices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OtherServices $otherServices)
    {
        
        // $validator = Validator::make($request->all(), [
        //     'title'=>'required',
        //     'description'=>'required',
        //     'image'=>'sometimes',
        //     'icon'=>'sometimes',
        // ]);
        $otherServices->title = $request->title;
        $otherServices->description = $request->description;
        $otherServices->icon = $request->icon;

        if ($request->hasfile('image')) {
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('service', $imageName);

            $otherServices->image = $imageName;
        }
        
        $otherServices->save();

        // $validated = $validator->validated(); 
        // $otherServices->update($validated);

        $response = [
            'message' => "Service Successfully Updated",
            'status'=> 200
        ];

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OtherServices  $otherServices
     * @return \Illuminate\Http\Response
     */
    public function destroy(OtherServices $otherServices)
    {
        $response = [];
        try {
            $otherServices = OtherServices::findOrFail($otherServices->id);
            $otherServices->delete();
            $response['success'] = true;
            $response['status']  = 200;
            $response['message'] = 'Successfully deleted!';
            $response['data']    = $otherServices;
        } catch( \Exception $e ) {
            $response['success'] = false;
            $response['status']  = 200;
            $response['message'] = 'Failed to delete service! | Error: '.$e->getMessage();
            $response['data']    = null;
        }
        return response($response, $response['status']);
    }
}
