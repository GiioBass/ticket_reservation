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
        $response->assertCreated();
    }

    public function testErrorDataCustomer(){
        $ticket = Ticket::factory()->make([
            'quantity' => ''
        ])->toArray();
        $response = $this->postJson('api/tickets', $ticket);
        $response->assertStatus(422);
    }

    public function testErrorDuplicateDataCustomer(){
        $ticket = Ticket::factory()->create()->toArray();
        $response = $this->postJson('api/tickets', $ticket);
        $response->assertStatus(422);
    }
}
