<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    private string $token = '';

    protected function setUp(): void
    {
        parent::setUp();

        // Crear un usuario de prueba y generar un token Sanctum
        $user = new User;
        $user->name = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = '-';
        $user->admin = true;
        $user->save();

        $this->token = $user->createToken('auth_token')->plainTextToken;
    }

    protected function headers()
    {
        return [
            'Authorization' => "Bearer {$this->token}",
        ];
    }

    public function test_register_user()
    {
        $userPrev = User::create([
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => '12345678'
        ]);

        $data = [
            'name' => mb_strtoupper('user2'),
            'email' => 'user2@user.com',
            'password' => '123456789'
        ];

        $response = $this->postJson('/api/auth/register', $data, $this->headers());

        $response->assertStatus(200);

        $data['id'] = $userPrev->id + 1;
        unset($data['password']);
        $this->assertDatabaseHas('users', $data);
    }
}
