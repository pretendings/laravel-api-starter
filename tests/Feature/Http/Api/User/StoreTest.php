<?php

namespace Tests\Feature\Http\Api\User;

use App\Models\User;
use Tests\TestCase;
use function factory;

class StoreTest extends TestCase
{
    public function test()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->json('post', 'api/user', [
            'name'  => 'Kings Code',
            'email' => 'info@kingscode.nl',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name'  => 'Kings Code',
            'email' => 'info@kingscode.nl',
        ]);
    }

    public function testValidationErrors()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->json('post', 'api/user');

        $response->assertStatus(422)->assertJsonValidationErrors([
            'name', 'email',
        ]);
    }
}
