<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
//    use RefreshDatabase;

    /**
     *
     */
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
}
