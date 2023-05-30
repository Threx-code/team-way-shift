<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShiftManagerUpdateTest extends TestCase
{
    public function test_should_fail_when_no_parameter_is_provided()
    {
        $response = $this->putJson(route("api.shift.update"), []);
        $response->assertStatus(422)
            ->assertJson([
                "message" => "The shift manager id field is required. (and 2 more errors)",
                "errors" => [
                    "shift_manager_id" => ["The shift manager id field is required."],
                    "user_id" => ["The user id field is required."],
                    "shift_id" =>["The shift id field is required."]
                ]
            ]);
    }

    public function test_should_fail_when_no_user_id_is_passed()
    {
        $response = $this->putJson(route("api.shift.update"), [
            "shift_manager_id" => 16,
            "shift_id" => 2,
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

    public function test_should_fail_when_no_shift_manager_id_is_passed()
    {
        $response = $this->putJson(route("api.shift.update"), [
            "user_id" => 23,
            "shift_id" => 1,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "message" => "The shift manager id field is required.",
                "errors" => [
                    "shift_manager_id" => [
                        "The shift manager id field is required."
                    ]
                ]
            ]);
    }

    public function test_should_fail_when_wrong_shift_manager_id_is_passed()
    {
        $response = $this->putJson(route("api.shift.update"), [
            "shift_manager_id" => 16999999,
            "user_id" => 23,
            "shift_id" => 1,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "message" => "The selected shift manager id is invalid.",
                "errors" => [
                    "shift_manager_id" => [
                        "The selected shift manager id is invalid."
                    ]
                ]
            ]);
    }

    public function test_should_fail_when_no_shift_id_is_passed()
    {
        $response = $this->putJson(route("api.shift.update"), [
            "user_id" => 23,
            "shift_manager_id" => 16,
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
        $response = $this->putJson(route("api.shift.update"), [
            "user_id" => 23,
            "shift_manager_id" => 16,
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

    public function test_should_fail_when_shift_does_not_exist_for_a_user()
    {
        $response = $this->putJson(route("api.shift.update"), [
            "user_id" => 23,
            "shift_manager_id" => 11,
            "shift_id" => 1,
        ]);
        $response->assertStatus(409)
            ->assertJson([
                "error" => "update error",
                "message" => "Sorry you cannot update this shift because it does not exist for this user"
            ]);
    }


    /**
     * @return void
     * @throws Exception
     */
    public function test_should_pass_when_a_shift_has_been_successfully_updated()
    {

        $date = Carbon::now();
        $response = $this->putJson(route("api.shift.update"), [
            "user_id" => 24,
            "shift_manager_id" => 11,
            "shift_id" => 2,
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'shift_updated' => true
            ]);
    }
}
