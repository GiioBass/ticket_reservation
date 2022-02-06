<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CustomerCollection
     */
    public function index()
    {
        return new CustomerCollection(Customer::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCustomerRequest $request): \Illuminate\Http\JsonResponse
    {
        try{

            $customer = Customer::create([
                'identification_number' => $request->identification_number,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'resource updated'
            ], 201);

        }catch(\Throwable $th){
            Log::error('Resource not created' . $th, ['customer' => $customer]);
            return response()->json([
                'status' => 'error',
                'message' => 'resource not created'
            ], 500);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return CustomerResource
     */
    public function show($identification_number)
    {
        try {

        $customer = Customer::where('identification_number', $identification_number)->get();

        if($customer->isEmpty() ){
            return response()->json([
                'status' => 'error',
                'message' => 'resource not found'
            ], 404);
        }

        return new CustomerResource($customer);

        }catch (\Throwable $th){
            return response()->json([
                'status' => 'error',
                'message' => 'resource not found'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCustomerRequest $request, $identification_number)
    {
        try{

        $customer = Customer::where('identification_number', $identification_number);
        $customer->update($request->all());

        return response()->json([
                'status' => 'success',
                'message' => 'resource updated'
            ], 201);

        }catch(\Throwable $th){
            Log::error('Resource not created' . $th);
            return response()->json([
                'status' => 'error',
                'message' => 'resource not created'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
