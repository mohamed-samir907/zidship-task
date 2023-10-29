<?php

namespace Tests\Feature;

use App\Models\Shipment;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShipmentControllerTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('app.dummy-courier', true);

        $this->seed(DatabaseSeeder::class);
    }

    /**
     * A basic feature test example.
     */
    public function test_only_post_mehtod_allowed(): void
    {
        $response = $this->getJson('/api/v1/shipments');

        $response->assertStatus(405);
    }

    public function test_can_not_create_shipment_without_auth(): void
    {
        $response = $this->postJson("/api/v1/shipments");

        $response->assertStatus(401);
    }

    public function test_get_validation_errors(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->postJson("/api/v1/shipments", [
            "platform" => "kwickbox",
            // "cod" => true,
            "pickup_date" => "2023-10-31",
            "sender" => [
                "name" => "Mohamed Samir",
                "phone" => "+201026687240",
                "email" => "gm.mohamedsamir@gmail.com",
                "country" => "EG",
                "state" => null,
                "city" => "Cairo",
                "postal_code" => null,
                "address_line1" => "Cairo",
                "address_line2" => null,
                "address_line3" => null
            ],
            "recipient" => [
                "name" => "Ahmed Samir",
                "phone" => "+201026687240",
                "email" => null,
                "country" => "EG",
                "state" => null,
                "city" => "Alexandria",
                "postal_code" => null,
                "address_line1" => "Alexandria",
                "address_line2" => null,
                "address_line3" => null
            ],
            "items" => [
                [
                    "title" => "Product 1",
                    "description" => null,
                    "quantity" => 1,
                    "weight" => 2.50,
                    "unit" => "kg",
                    "price" => 500
                ]
            ]
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            "message" => "The cod field is required."
        ]);
    }

    public function test_create_valid_shipment(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->postJson("/api/v1/shipments", [
            "platform" => "kwickbox",
            "cod" => true,
            "pickup_date" => "2023-10-31",
            "sender" => [
                "name" => "Mohamed Samir",
                "phone" => "+201026687240",
                "email" => "gm.mohamedsamir@gmail.com",
                "country" => "EG",
                "state" => null,
                "city" => "Cairo",
                "postal_code" => null,
                "address_line1" => "Cairo",
                "address_line2" => null,
                "address_line3" => null
            ],
            "recipient" => [
                "name" => "Ahmed Samir",
                "phone" => "+201026687240",
                "email" => null,
                "country" => "EG",
                "state" => null,
                "city" => "Alexandria",
                "postal_code" => null,
                "address_line1" => "Alexandria",
                "address_line2" => null,
                "address_line3" => null
            ],
            "items" => [
                [
                    "title" => "Product 1",
                    "description" => null,
                    "quantity" => 1,
                    "weight" => 2.50,
                    "unit" => "kg",
                    "price" => 500
                ]
            ]
        ]);

        $response->assertStatus(201);

        // 1 from the seeder and 1 created from the api
        $this->assertDatabaseCount(Shipment::class, 2);
    }

    public function test_getting_the_shipment_status(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->getJson("/api/v1/shipments/1/status");

        $response->assertStatus(200);
        $response->assertJson([
            "data" => [
                "status" => "received",
            ],
        ]);
    }

    public function test_getting_the_shipment_print_label_url(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->getJson("/api/v1/shipments/1/print");

        $response->assertStatus(200);
        $response->assertJson([
            "data" => [
                "url" => "https://fake-url.com/shipment-label.pdf"
            ],
        ]);
    }

    public function test_cancel_the_shipment(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->putJson("/api/v1/shipments/1/cancel");

        $response->assertStatus(200);
        $response->assertJson([
            "data" => [],
        ]);
    }
}
