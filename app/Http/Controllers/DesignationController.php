<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'select_key' => ['required'],
        ]);
        if ($validator->fails()) {
            $response['status'] = 'failed';
            $response['status_code'] = 422;
            $response['message'] = $validator->errors()->first();
            return response()->json($response)->setStatusCode(422);
        }
        $selectText = $request->select_key;
        $designation = Designation::where('department_id',$selectText)->get();
        if (count($designation)>0) {
            $response['status'] = 200;
            $response['message'] = 'user Found';
            $response['user_info'] = $designation;
            return response()->json($response);
        }
        else{
            $response['status'] = 404;
            $response['message'] = 'No user Found';
            $response['user_info'] = $designation;
            return response()->json($response);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        //
    }
}
