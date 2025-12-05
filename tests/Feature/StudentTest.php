<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Student;

class StudentTest extends TestCase
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

    public function test_list_students()
    {
        $students = [
            [
                'name' => 'María González',
                'email' => 'maria.gonzalez@example.com',
                'birthday' => '1995-03-12',
                'nationality' => 'argentina'
            ],
            [
                'name' => 'Carlos Romero',
                'email' => 'c.romero92@example.com',
                'birthday' => '1992-07-25',
                'nationality' => 'chilena'
            ],
            [
                'name' => 'Lucía Fernández',
                'email' => 'lucia.fernandez@example.com',
                'birthday' => '1998-11-05',
                'nationality' => 'uruguaya'
            ]
        ];
        Student::insert($students);

        $response = $this->getJson('/api/students', $this->headers());

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_show_student()
    {
        $student = Student::create([
            'name' => 'María González',
            'email' => 'maria.gonzalez@example.com',
            'birthday' => '1995-03-12',
            'nationality' => 'argentina'
        ]);

        $response = $this->getJson("/api/students/{$student->id}", $this->headers());

        $response->assertStatus(200)
            ->assertJson([
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'birthday' => $student->birthday,
                'nationality' => $student->nationality,
            ]);
    }

    public function test_create_student()
    {
        $data = [
            'name' => mb_strtoupper('María González'),
            'email' => 'maria.gonzalez@example.com',
            'birthday' => '1995-03-12',
            'nationality' => mb_strtoupper('argentina')
        ];

        $response = $this->postJson('/api/students', $data, $this->headers());

        $response->assertStatus(200);

        $this->assertDatabaseHas('students', $data);
    }

    public function test_update_student()
    {
        $student = Student::create([
            'name' => 'María González',
            'email' => 'maria.gonzalez@example.com',
            'birthday' => '1995-03-12',
            'nationality' => 'argentina'
        ]);

        $updateData = [
            'name' => mb_strtoupper('María González 2'),
            'email' => 'maria.gonzalez@example.com.py',
            'birthday' => mb_strtoupper('1995-10-20'),
            'nationality' => mb_strtoupper('chilena'),
        ];

        $response = $this->putJson("/api/students/{$student->id}", $updateData, $this->headers());
        $response->assertStatus(200);

        $response = $this->getJson("/api/students/{$student->id}", $this->headers());
        $response->assertStatus(200)
            ->assertJsonFragment($updateData);

        $this->assertDatabaseHas('students', array_merge(['id' => $student->id], $updateData));
    }

    public function test_delete_student()
    {
        $student = Student::create([
            'name' => 'María González',
            'email' => 'maria.gonzalez@example.com',
            'birthday' => '1995-03-12',
            'nationality' => 'argentina'
        ]);

        $response = $this->deleteJson(uri: "/api/students/{$student->id}", headers: $this->headers());

        $response->assertStatus(200);

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }
}
