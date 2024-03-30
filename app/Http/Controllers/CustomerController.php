<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Department;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search_key' => ['required'],
        ]);
        if ($validator->fails()) {
            $response['status'] = 'failed';
            $response['status_code'] = 422;
            $response['message'] = $validator->errors()->first();
            return response()->json($response)->setStatusCode(422);
        }
        $searchText = $request->search_key;
        $customer = Customer::where('name', 'like', '%' . $searchText . '%')
            ->orWhereHas('department', function ($query) use ($searchText) {
                $query->where('name', 'like', '%' . $searchText . '%');
            })
            ->orWhereHas('designation', function ($query) use ($searchText) {
                $query->where('name', 'like', '%' . $searchText . '%');
            })
            ->with('department', 'designation')
            ->get();
        if (count($customer)>0) {
            $response['status'] = 200;
            $response['message'] = 'user Found';
            $response['user_info'] = $customer;
            return response()->json($response);
        }
        else{
            $response['status'] = 404;
            $response['message'] = 'No user Found';
            $response['user_info'] = $customer;
            return response()->json($response);
        }
    }
    public function listing()
    {
        $users = Customer::whereHas('department')->whereHas('designation')->with('department', 'designation')->get();
        foreach ($users as $user) {
            $user->department_name = $user->department->name;
            $user->designation_name = $user->designation->name;
        }
        return view('user.index', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::get();
        return view('user.create',compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|unique:customers,name' ,
            'phone' => 'required|unique:customers,phone|numeric|digits:10',
            'department'=>'required',
            'designation'=>'required',

        ])->validate();
        try {
            DB::beginTransaction();
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->department_id = $request->department;
            $customer->designation_id = $request->designation;
            $customer->save();
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            logger($ex);
            return back()->with('error', __('app.error'))->withInput();
        }
        return redirect()->route('customer.listing')->with('success','User Added!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
