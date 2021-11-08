<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investment;

class InvestmentController extends Controller
{

     /**
     * Update Investment
     * @return Illuminate\Facades\Support\Response
     */
    public function index($status)
    {
        $status = $status || 1;
        $investments = Investment::where('status', Investment::STATUS[$status])
                                ->get();
        return response([
            'success' => true,
            'data'    => $investments,
        ]);
    }

     /**
     * Create Investment
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Facades\Support\Response
     */
    public function store(Request $request)
    {
        try {
            $investment          = Investment::create($request->all());
            $response['success'] = true;
            $response['message'] = 'Successfully created!';
            $response['data']    = $investment; 
        } catch ( \Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
            $response['data']    = null; 
        }

        return response($response);
    }

    /**
     * Update Investment
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Facades\Support\Response
     */
    public function update(Request $request)
    {
        try {
            $investment          = Investment::update($request->all());
            $response['success'] = true;
            $response['message'] = 'Successfully updated!';
            $response['data']    = $investment; 
        } catch ( \Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
            $response['data']    = null; 
        }

        return response($response);
    }

    /**
     * Delete Investment
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Facades\Support\Response
     */
    public function destroy(Request $request)
    {
        try {
            $investment          = Investment::findOrFail($request->id);
            $response['success'] = true;
            $response['message'] = 'Successfully deleted!';
            $response['data']    = $investment; 
        } catch ( \Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
            $response['data']    = null; 
        }

        return response($response);
    }
}
