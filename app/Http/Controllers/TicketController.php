<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\TicketCollection;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TicketCollection
     */
    public function index(): TicketCollection
    {
        return new TicketCollection(Ticket::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTicketRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTicketRequest $request): \Illuminate\Http\JsonResponse
    {
        try{

            $ticket = Ticket::create([
                'name' => $request->name,
                'code' => $request->code,
                'quantity' => $request->quantity,
                'price' => $request->price
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'resource created'
            ], 201);

        }catch(\Throwable $th){
            Log::error('Resource not created' . $th, [ 'ticket' => $ticket]);
            return response()->json([
                'status' => 'error',
                'message' => 'resource not created'
            ], 500);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return TicketResource
     */
    public function show($code)
    {
        try {

            $ticket = Ticket::where('code', $code)->get();

            if($ticket->isEmpty() ){
                return response()->json([
                    'status' => 'error',
                    'message' => 'resource not found'
                ], 404);
            }

            return new TicketResource($ticket);

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
     * @param  \App\Http\Requests\UpdateTicketRequest  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTicketRequest $request, $code)
    {
        try{

            $ticket = Ticket::where('code', $code);
            $ticket->update($request->all());

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
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
