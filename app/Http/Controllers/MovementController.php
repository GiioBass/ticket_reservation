<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovementRequest;
use App\Http\Requests\UpdateMovementRequest;
use App\Models\Movement;
use App\Models\Ticket;
use Illuminate\Support\Facades\Log;

class MovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMovementRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreMovementRequest $request): \Illuminate\Http\JsonResponse
    {
        try{

            $priceTicket = Ticket::findOrFail($request->ticket_id)->price;

            $movement = Movement::create([
                'total_amount' => $request->quantity * $priceTicket,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'ticket_id' => $request->ticket_id,
                'customer_id' => $request->customer_id
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'resource created'
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
     * Display the specified resource.
     *
     * @param  \App\Models\Movement  $movement
     * @return \Illuminate\Http\Response
     */
    public function show(Movement $movement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMovementRequest  $request
     * @param  \App\Models\Movement  $movement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMovementRequest $request, Movement $movement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movement  $movement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movement $movement)
    {
        //
    }
}
