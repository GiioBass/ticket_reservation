<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Models\Movement;
use App\Models\Status;
use App\Models\Ticket;
use Database\Seeders\StatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class MovementControllerTest extends TestCase
{

    use RefreshDatabase;

    public function testStoreMovementSuccess(){
        $ticket = Ticket::factory()->create([
            'quantity' => 200
        ]);
        $status = Status::factory()->create();
        $movement = Movement::factory()
            ->for($ticket)
            ->forCustomer()
            ->for($status)
            ->make([
                'quantity' => 100
            ])->toArray();
        $response = $this->postJson('api/movements', $movement);
        $response->assertCreated();
    }

    public function testStoreMovementSuccessValidatedQuantityOfTickets(){
        $status = Status::factory()->create();
        $ticket = Ticket::factory()->create([
            'quantity' => 200
        ]);
        $movement = Movement::factory()
            ->for($ticket)
            ->for($status)
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
        $status = Status::factory()->create();
        $movement = Movement::factory()
            ->for($ticket)
            ->for($status)
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
        $status = Status::factory()->create();
        $ticket = Ticket::factory()->create([
            'quantity' => 100
        ]);
        Movement::factory()
            ->for($ticket)
            ->forCustomer()
            ->for($status)
            ->create([
                'quantity' => 50,
                'total_amount' => 50000
            ]);

        $response = $this->getjson('api/movements');
        $response->assertOk();
    }

    public function testShowResourceMovement(){
        $status = Status::factory()->create();
        $ticket = Ticket::factory()->create([
            'quantity' => 100
        ]);
        Movement::factory()
            ->for($ticket)
            ->forCustomer()
            ->for($status)
            ->create([
                'quantity' => 50,
                'total_amount' => 50000
            ]);

        $response = $this->getjson('api/movements/'. $ticket->purchase_reference);
        $response->assertOk();
    }

    public function testShowResourceMovementNotFound(){
        $status = Status::factory()->create();
        $ticket = Ticket::factory()->create([
            'quantity' => 100
        ]);
        Movement::factory()
            ->for($ticket)
            ->forCustomer()
            ->for($status)
            ->create([
                'quantity' => 50,
                'total_amount' => 50000
            ]);

        $response = $this->getjson('api/movements/12345678');
        $response->assertNotFound();
    }

    public function testUpdateResourceMovement(){
        $status = Status::factory()->create();
        $ticket = Ticket::factory()->create([
            'quantity' => 100
        ]);
        $movement = Movement::factory()
            ->for($ticket)
            ->forCustomer()
            ->for($status)
            ->create([
                'quantity' => 50,
                'total_amount' => 50000
            ]);

        $response = $this->putjson('api/movements/' . $movement->purchase_reference,[
            'quantity' => 60,
            'total_amount' => 100000
        ]);

        $this->assertDatabaseHas('movements', [
            'purchase_reference' => $movement->purchase_reference,
            'quantity' => 60,
            'total_amount' => 100000
        ]);
    }

    public function testUpdateResourceMovementCancelReservationDiscount(){

        $this->seed(StatusSeeder::class);
        $ticket = Ticket::factory()->create([
            'quantity' => 100
        ]);
        $movement = Movement::factory()
            ->for($ticket)
            ->forCustomer()
            ->create([
                'quantity' => 50,
                'total_amount' => 50000,
                'status_id' => 1
            ]);

        $response = $this->putjson('api/movements/' . $movement->purchase_reference,[
            'status_id' => 4
        ]);

        $this->assertDatabaseHas('movements', [
            'purchase_reference' => $movement->purchase_reference,
            'status_id' => 4
        ]);
    }

    public function testUpdateQuantityticketsCancelReservation(){

        $this->seed(StatusSeeder::class);
        $ticket = Ticket::factory()->create([
            'quantity' => 100
        ]);
        $movement = Movement::factory()
            ->for($ticket)
            ->forCustomer()
            ->create([
                'quantity' => 50,
                'total_amount' => 50000,
                'status_id' => 1
            ]);

        $response = $this->putjson('api/movements/' . $movement->purchase_reference,[
            'status_id' => 4
        ]);

        $this->assertDatabaseHas('tickets', [
            'code' => $ticket->code,
            'quantity' => 150
        ]);
    }

}
