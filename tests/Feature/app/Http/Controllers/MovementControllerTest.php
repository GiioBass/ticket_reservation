<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Models\Movement;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class MovementControllerTest extends TestCase
{

    use RefreshDatabase;

    public function testStoreMovementSuccess(){
        $ticket = Ticket::factory()->create([
            'quantity' => 200
        ]);
        $movement = Movement::factory()
            ->for($ticket)
            ->forCustomer()
            ->make([
                'quantity' => 100
            ])->toArray();
        $response = $this->postJson('api/movements', $movement);
        $response->assertCreated();
    }

    public function testStoreMovementSuccessValidatedQuantityOfTickets(){
        $ticket = Ticket::factory()->create([
            'quantity' => 200
        ]);
        $movement = Movement::factory()
            ->for($ticket)
            ->forCustomer()
            ->make([
                'quantity' => 100
            ])->toArray();
        $response = $this->postJson('api/movements', $movement);
        $this->assertDatabaseHas('tickets',[
            'id' => $ticket->id,
            'quantity' => 100
        ]);
    }

    public function testQuantityRequiredIsNotAvailable(){
        $ticket = Ticket::factory()->create([
            'quantity' => 50
        ]);
        $movement = Movement::factory()
            ->for($ticket)
            ->forCustomer()
            ->make([
                'quantity' => 100
            ])->toArray();
        $response = $this->postJson('api/movements', $movement);
        $response->assertJson([
            'status' => 'error',
            'message' => 'the required quantity is not available'
        ]);
    }


    public function testErrorDataMovement(){
        $movement = Movement::factory()
            ->forTicket()
            ->make()->toArray();
        $response = $this->postJson('api/movements', $movement);
        $response->assertStatus(422);
    }

    public function testIndexMovement(){
        $ticket = Ticket::factory()->create([
            'quantity' => 100
        ]);
        Movement::factory()
            ->for($ticket)
            ->forCustomer()
            ->create([
                'quantity' => 50,
                'total_amount' => 50000
            ]);

        $response = $this->getjson('api/movements');
        $response->assertOk();
    }

    public function testShowResourceMovementNotFound(){
        $ticket = Ticket::factory()->create([
            'quantity' => 100
        ]);
        Movement::factory()
            ->for($ticket)
            ->forCustomer()
            ->create([
                'quantity' => 50,
                'total_amount' => 50000
            ]);

        $response = $this->getjson('api/movements/'. $ticket->purchase_reference);
        $response->dump();
        $response->assertOk();
    }

}
