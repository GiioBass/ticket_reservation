<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreCustomerSuccess(){
        $customer = Customer::factory()->make()->toArray();
        $response = $this->postJson('api/customers', $customer);
        $response->assertCreated();
    }

    public function testErrorDataCustomer(){
        $customer = Customer::factory()->make([
            'identification_number' => ''
        ])->toArray();
        $response = $this->postJson('api/customers', $customer);
        $response->assertStatus(422);
    }

    public function testErrorDuplicateDataCustomer(){
        $customer = Customer::factory()->create()->toArray();
        $response = $this->postJson('api/customers', $customer);
        $response->assertStatus(422);
    }

    public function testIndexCustomer(){
        Customer::factory()->count(50)->create();
        $response = $this->getJson('api/customers',[
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
        ]);
        $response->assertOk();
    }

    public function testShowResourceCustomerSuccess(){
        $customer = Customer::factory()->create();
        $response = $this->getJson('api/customers/' . $customer->identification_number);
        $response->dump();
        $response->assertOk();
    }

    public function testShowResourceCustomerNotFound(){
        Customer::factory()->create();
        $response = $this->getJson('api/customers/12345678' );
        $response->assertNotFound();
    }

    public function testUpdateResourceCustomerSuccess(){

        $customer = Customer::factory()->create();

        $response = $this->putJson('api/customers/' . $customer->identification_number, [
            'phone' => '748159263',
            'email' => 'email@email.co'
        ]);
        $this->assertDatabaseHas('customers', [
            'identification_number' => $customer->identification_number,
            'phone' => '748159263',
            'email' => 'email@email.co'
        ]);
    }
}
