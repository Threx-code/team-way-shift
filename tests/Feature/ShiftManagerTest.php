<?php

namespace Tests\Feature;

use App\Helpers\Helper;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShiftManagerTest extends TestCase
{
    public function test_should_fail_when_no_parameter_is_provided()
    {
        $response = $this->postJson(route("api.shift.create"), []);
        $response->assertStatus(422)
            ->assertJson([
                "message" => "The shift date field is required. (and 3 more errors)",
                "errors" => [
                    "shift_date" => [
                        "The shift date field is required."
                    ],
                    "user_id" => [
                        "The user id field is required."
                    ],
                    "manager_id" => [
                        "The manager id field is required."
                    ],
                    "shift_id" => [
                        "The shift id field is required."
                    ]
                ]
            ]);
    }

    public function test_should_fail_when_no_user_id_is_passed()
    {
        $response = $this->postJson(route("api.shift.create"), [
            "shift_date" => ["2023-05-21", "2023-05-22", "2023-05-23", "2023-05-24", "2023-05-23", "2023-05-26", "2023-05-23", "2023-05-24"],
            "shift_id" => 2,
            "manager_id" => 12,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "message" =>  "The user id field is required.",
                "errors" => [
                    "user_id" => [
                        "The user id field is required."
                    ]
                ]
            ]);
    }

    public function test_should_fail_when_no_manager_id_is_passed()
    {
        $response = $this->postJson(route("api.shift.create"), [
            "shift_date" => ["2023-05-21", "2023-05-22", "2023-05-23", "2023-05-24", "2023-05-23", "2023-05-26", "2023-05-23", "2023-05-24"],
            "user_id" => 23,
            "shift_id" => 1,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "message" => "The manager id field is required.",
                "errors" => [
                    "manager_id" => [
                        "The manager id field is required."
                    ]
                ]
            ]);
    }

    public function test_should_fail_when_no_shift_id_is_passed()
    {
        $response = $this->postJson(route("api.shift.create"), [
            "shift_date" => ["2023-05-21", "2023-05-22", "2023-05-23", "2023-05-24", "2023-05-23", "2023-05-26", "2023-05-23", "2023-05-24"],
            "user_id" => 23,
            "manager_id" => 12,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "message" => "The shift id field is required.",
                "errors" => [
                    "shift_id" => [
                        "The shift id field is required."
                    ]
                ]
            ]);
    }

    public function test_should_fail_when_wrong_shift_id_is_passed()
    {
        $response = $this->postJson(route("api.shift.create"), [
            "shift_date" => ["2023-05-21", "2023-05-22", "2023-05-23", "2023-05-24", "2023-05-23", "2023-05-26", "2023-05-23", "2023-05-24"],
            "user_id" => 23,
            "manager_id" => 12,
            "shift_id" => 100,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "message" => "The selected shift id is invalid.",
                "errors" => [
                    "shift_id" => [
                        "The selected shift id is invalid."
                    ]
                ]
            ]);
    }

    public function test_should_fail_when_shifts_are_already_created_for_a_user()
    {
        $response = $this->postJson(route("api.shift.create"), [
            "shift_date" => ["2023-05-21", "2023-05-22", "2023-05-23"],
            "user_id" => 23,
            "manager_id" => 12,
            "shift_id" => 1,
        ]);
        $response->assertStatus(409)
            ->assertJson([
                "error" => "insertion error",
                "message" => "shift dates already entered for this user"
            ]);
    }


    /**
     * @return void
     * @throws Exception
     */
    public function test_should_pass_when_a_shift_has_been_successfully_created()
    {

        $date = Carbon::now();
        $response = $this->postJson(route("api.shift.create"), [
            "shift_date" => [
                $date->addDay(random_int(10, 999))->format('Y-m-d')
            ],
            "user_id" => 23,
            "manager_id" => 12,
            "shift_id" => 1,
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'shift_created' => true
            ]);
    }

}
