<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('api/tasks');

        $response->assertOk();
    }

    public function test_request_with_all_filled_correct_params(): void
    {
        $params = [
            'status' => [
                'operator' => 'is',
                'value' => 'in_progress',
                'boolean' => 'or',
            ],
            'estimate' => [
                'operator' => 'in',
                'value' => '1,2',
                'boolean' => 'and',
            ],
            'content' => [
                'operator' => 'contains',
                'value' => 'libero',
            ],
        ];
        $params = http_build_query($params);
        $response = $this->get("api/tasks?$params");

        $response->assertOk();
    }

    public function test_request_with_incorrect_params(): void
    {
        $response = $this->get('api/tasks?asdfasdf=Boperatasfaadgasdgasd');
        $response->assertValid();

        $response = $this->get('api/tasks?filters=Boperatasfaadgasdgasd');
        $response->assertStatus(422);

        $response = $this->get('api/tasks?filters%5Bstatus%5D=akjhda');
        $response->assertStatus(422);
    }
}
