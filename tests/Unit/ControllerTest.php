<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class ControllerTest extends TestCase
{
    /**
     * Setting up test.
     * 
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * User register test.
     *
     * @return void
     */
    public function testRegister(): void
    {
        $this->postJson('/api/register', [
            'email' => 'user@example.com',
        ])->assertStatus(422);

        $this->postJson('/api/register', [
            'email' => 'user@example.com',
            'name' => 'User Name',
            'password' => 'qwerty',
            'password_confirmation' => 'qwerty',
        ])->assertStatus(200);

        User::where('email', 'user@example.com')
            ->first()
            ->markEmailAsVerified();
    }

    /**
     * Price subscribe test.
     * 
     * @return void
     */
    public function testSubscribe(): void
    {
        $user = \App\Models\User::where('email', 'user@example.com')->first();
        $user->markEmailAsVerified();
        $token = $user->createToken($user->name)->plainTextToken;

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('post', '/api/price/subscribe', [
                'email' => 'user@example.com'
            ])
            ->assertStatus(422);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('post', '/api/price/subscribe', [
                'link' => 'https://olx.ua'
            ])
            ->assertStatus(200);
    }

    /**
     * Price unsubscribe test.
     * 
     * @return void
     */
    public function testUnsubscribe(): void
    {
        $token = User::where('email', 'user@example.com')
            ->first()
            ->createToken('test')
            ->plainTextToken;

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('post', '/api/price/unsubscribe', [
                'link' => 'https://example.com'
            ])
            ->assertStatus(404);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('post', '/api/price/unsubscribe', [
                'link' => 'https://olx.ua'
            ])
            ->assertStatus(200);
    }

    /**
     * Delete user test.
     * 
     * @return void
     */
    public function testDelete(): void
    {
        $token = User::where('email', 'user@example.com')
            ->first()
            ->createToken('test')
            ->plainTextToken;

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('delete', '/api/user', [])
            ->assertStatus(200);
    }
}
