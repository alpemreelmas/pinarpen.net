<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    //TODO user auth kısmı kısaltılacak.
    use RefreshDatabase;

    public function test_customer_index_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/admin/accounting/customers');

        $response->assertStatus(200);
    }

    public function test_customer_create_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/admin/accounting/customers/create');

        $response->assertStatus(200);
    }

    public function test_customer_create_store()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/admin/accounting/customers', Customer::factory()->make()->toArray());

        $customer = Customer::firstOrFail();

        $response->assertStatus(302);

        $response = $this->followRedirects($response);

        $response->assertStatus(200)->assertSee($customer->name);
    }

    public function test_customer_edit_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/admin/accounting/customers', Customer::factory()->make()->toArray());

        $customer = Customer::firstOrFail();

        $response = $this->get('/admin/accounting/customers/'.$customer->id.'/edit');

        $response->assertStatus(200);
    }

    public function  test_customer_update_store()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $customer = Customer::factory()->create();

        $response = $this->put('/admin/accounting/customers/'.$customer->id, [
            'name' => 'hasan',
            'surname' => 'fakir',
            'phone_number'=>'5864561486416',
        ]);

        $response->assertStatus(302);

        $response = $this->followRedirects($response);

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'hasan',
            'surname' => 'fakir'
        ]);

        $response->assertStatus(200)->assertSee('hasan');
    }

    public function  test_customer_inspect()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $customer = Customer::factory()->create();

        $response = $this->get('/admin/accounting/customers/'.$customer->id.'/inspect');

        $response->assertStatus(200);
    }

}
