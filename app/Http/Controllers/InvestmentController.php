<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Investment;
use App\Http\Requests\InvestmentRequest;
use App\Http\Controllers\ImageController;

class InvestmentController extends Controller
{
    protected $imageController;

    function __construct()
    {
        $this->imageController = new ImageController();
    }

     /**
     * Update Investment
     * @return Illuminate\Facades\Support\Response
     */
    public function index()
    {
        $investments = (isset($request->status)) ? 
                    $investments = Investment::orderBy('created_at', 'desc')
                                    ->where('status', Investment::$STATUS[request()->status])->get()
                    : $investments = Investment::orderBy('created_at', 'desc')->get();

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
    public function store(InvestmentRequest $request)
    {
        DB::beginTransaction();
        try {
            $data                = $request->all();
            $data['image']       = $this->imageController->saveImageAndGetImageName($request);

            $investment          = Investment::create($data);
            $response['success'] = true;
            $response['message'] = 'Successfully created!';
            $response['data']    = $investment; 
            DB::commit();
        } catch ( \Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
            $response['data']    = null;
            DB::rollback();
        }

        return response($response);
    }

    /**
     * Update Investment
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Facades\Support\Response
     */
    public function update(InvestmentRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $imageName = $this->imageController->saveImageAndGetImageName($request);
            $data = $request->all();
            if ($imageName) {
                $data['image'] = $imageName;
            }

            $investment = Investment::findOrFail($id);
            $investment->update($data);
            $response['success'] = true;
            $response['message'] = 'Successfully updated!';
            $response['data']    = $investment;
            DB::commit();
        } catch ( \Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
            $response['data']    = null;
            DB::rollback();
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
        DB::beginTransaction();
        try {
            $investment          = Investment::findOrFail($request->id);
            $response['success'] = true;
            $response['message'] = 'Successfully deleted!';
            $response['data']    = $investment;
            DB::commit();
        } catch ( \Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
            $response['data']    = null;
            DB::rollback();
        }

        return response($response);
    }
}
