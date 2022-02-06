<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Models\Movement;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class MovementControllerTest extends TestCase
{

    use RefreshDatabase;

    public function testStoreMovementSuccess(){
        $movement = Movement::factory()
            ->forTicket()
            ->forCustomer()
            ->make()->toArray();
        $response = $this->postJson('api/movements', $movement);
        $response->assertCreated();
    }

    public function testErrorDataMovement(){
        $movement = Movement::factory()
            ->forTicket()
            ->make()->toArray();
        $response = $this->postJson('api/movements', $movement);
        $response->assertStatus(422);
    }


}
