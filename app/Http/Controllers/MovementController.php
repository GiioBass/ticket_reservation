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
            $ticket = Ticket::findOrFail($request->ticket_id);

            if ($request->quantity > $ticket->quantity){
                return response()->json([
                    'status' => 'error',
                    'message' => 'the required quantity is not available'
                ]);
            }

            $movement = Movement::create([
                'total_amount' => $request->quantity * $ticket->price,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'ticket_id' => $request->ticket_id,
                'customer_id' => $request->customer_id
            ]);

            $ticket->quantity = $ticket->quantity - $request->quantity;
            $ticket->save();

            return response()->json([
                'status' => 'success',
                'message' => 'resource created'
            ], 201);

        }catch(\Throwable $th){
            Log::error('Resource not created' . $th, ['movement' => $movement]);
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
