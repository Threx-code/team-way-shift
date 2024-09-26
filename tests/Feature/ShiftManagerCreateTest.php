<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShiftManagerCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_fail_when_no_parameter_is_provided()
    {
        $response = $this->postJson(route("api.shift.create"), []);
        $response->assertStatus(422)
            ->assertJson([
                "message" => "The shift date field is required. (and 3 more errors)",
                "errors" => [
                    "shift_date" => ["The shift date field is required."],
                    "user_id" => ["The user id field is required."],
                    "manager_id" => ["The manager id field is required."],
                    "shift_id" => ["The shift id field is required."]
                ]
            ]);
    }

    public function test_should_fail_when_no_user_id_is_passed()
    {
        $manager = User::factory()->create();
        $shift = Shift::factory()->create();

        $response = $this->postJson(route("api.shift.create"), [
            "shift_date" => ["2023-05-21", "2023-05-22"],
            "shift_id" => $shift->id,
            "manager_id" => $manager->id,
        ]);

        $response->assertStatus(422)
            ->assertJson([
                "message" => "The user id field is required.",
                "errors" => [
                    "user_id" => ["The user id field is required."]
                ]
            ]);
    }

    public function test_should_fail_when_no_manager_id_is_passed()
    {
        $user = User::factory()->create();
        $shift = Shift::factory()->create();

        $response = $this->postJson(route("api.shift.create"), [
            "shift_date" => ["2023-05-21", "2023-05-22"],
            "user_id" => $user->id,
            "shift_id" => $shift->id,
        ]);

        $response->assertStatus(422)
            ->assertJson([
                "message" => "The manager id field is required.",
                "errors" => [
                    "manager_id" => ["The manager id field is required."]
                ]
            ]);
    }

    public function test_should_fail_when_no_shift_id_is_passed()
    {
        $user = User::factory()->create();
        $manager = User::factory()->create();

        $response = $this->postJson(route("api.shift.create"), [
            "shift_date" => ["2023-05-21", "2023-05-22"],
            "user_id" => $user->id,
            "manager_id" => $manager->id,
        ]);

        $response->assertStatus(422)
            ->assertJson([
                "message" => "The shift id field is required.",
                "errors" => [
                    "shift_id" => ["The shift id field is required."]
                ]
            ]);
    }

    public function test_should_fail_when_wrong_shift_id_is_passed()
    {
        $user = User::factory()->create();
        $manager = User::factory()->create();

        $response = $this->postJson(route("api.shift.create"), [
            "shift_date" => ["2023-05-21", "2023-05-22"],
            "user_id" => $user->id,
            "manager_id" => $manager->id,
            "shift_id" => 100,  // Non-existent shift_id
        ]);

        $response->assertStatus(422)
            ->assertJson([
                "message" => "The selected shift id is invalid.",
                "errors" => [
                    "shift_id" => ["The selected shift id is invalid."]
                ]
            ]);
    }

    public function test_should_fail_when_shifts_are_already_created_for_a_user()
    {
        $user = User::factory()->create();
        $manager = User::factory()->create();
        $shift = Shift::factory()->create();

        // Simulate already existing shifts
        $this->postJson(route("api.shift.create"), [
            "shift_date" => ["2023-05-21", "2023-05-22", "2023-05-23"],
            "user_id" => $user->id,
            "manager_id" => $manager->id,
            "shift_id" => $shift->id,
        ]);

        // Attempt to create the same shifts again
        $response = $this->postJson(route("api.shift.create"), [
            "shift_date" => ["2023-05-21", "2023-05-22", "2023-05-23"],
            "user_id" => $user->id,
            "manager_id" => $manager->id,
            "shift_id" => $shift->id,
        ]);

        $response->assertStatus(409)
            ->assertJson([
                "error" => "insertion error",
                "message" => "shift dates already entered for this user"
            ]);
    }

    public function test_should_pass_when_a_shift_has_been_successfully_created()
    {
        $user = User::factory()->create();
        $manager = User::factory()->create();
        $shift = Shift::factory()->create();

        $date = Carbon::now();
        $response = $this->postJson(route("api.shift.create"), [
            "shift_date" => [
                $date->addDay(random_int(10, 999))->format('Y-m-d')
            ],
            "user_id" => $user->id,
            "manager_id" => $manager->id,
            "shift_id" => $shift->id,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'shift_created' => true
            ]);
    }
}
