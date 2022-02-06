<?php

namespace Tests\Feature\app\Http\Controllers;


use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreTicketSuccess(){
        $ticket = Ticket::factory()->make()->toArray();
        $response =$this->postJson('api/tickets', $ticket);
        $response->dump();
        $response->assertCreated();
    }

    public function testErrorDataTicket(){
        $ticket = Ticket::factory()->make([
            'quantity' => ''
        ])->toArray();
        $response = $this->postJson('api/tickets', $ticket);
        $response->assertStatus(422);
    }

    public function testErrorDuplicateDataTicket(){
        $ticket = Ticket::factory()->create()->toArray();
        $response = $this->postJson('api/tickets', $ticket);
        $response->assertStatus(422);
    }

    public function testIndexTicket(){
        Ticket::factory()->count(50)->create();
        $response = $this->getJson('api/tickets',[
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
        ]);
        $response->assertOk();
    }

    public function testShowResourceTicketSuccess(){
        $ticket = Ticket::factory()->create();
        $response = $this->getJson('api/tickets/' . $ticket->code);
        $response->assertOk();
    }

    public function testShowResourceTicketNotFound(){
        Ticket::factory()->create();
        $response = $this->getJson('api/tickets/12345678' );
        $response->assertNotFound();
    }

    public function testUpdateResourceTicketSuccess(){

        $ticket = Ticket::factory()->create();

        $response = $this->putJson('api/tickets/' . $ticket->code, [
            'quantity' => '1000',
            'price' => '50000'
        ]);
        $this->assertDatabaseHas('tickets', [
            'code' => $ticket->code,
            'quantity' => '1000',
            'price' => '50000'
        ]);
    }

}
