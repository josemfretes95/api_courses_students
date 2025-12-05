<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;

class CoursesTest extends TestCase
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

    public function test_list_courses()
    {
        $courses = [
            [
                'title' => 'Curso de Programación en PHP',
                'description' => 'Introducción práctica al desarrollo backend con PHP.',
                'start_date' => '2025-01-15',
                'end_date' => '2025-02-15'
            ],
            [
                'title' => 'Curso de Desarrollo Web Full Stack',
                'description' => 'Aprende frontend y backend con tecnologías modernas.',
                'start_date' => '2025-03-01',
                'end_date' => '2025-06-01'
            ],
            [
                'title' => 'Curso de Bases de Datos MySQL',
                'description' => 'Fundamentos y prácticas avanzadas de MySQL.',
                'start_date' => '2025-04-10',
                'end_date' => '2025-05-10'
            ]
        ];
        Course::insert($courses);

        $response = $this->getJson('/api/courses', $this->headers());

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_show_course()
    {
        $course = Course::create([
            'title' => 'Curso de Programación en PHP',
            'description' => 'Introducción práctica al desarrollo backend con PHP.',
            'start_date' => '2025-01-15',
            'end_date' => '2025-02-15'
        ]);

        $response = $this->getJson("/api/courses/{$course->id}", $this->headers());

        $response->assertStatus(200)
            ->assertJson([
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'start_date' => $course->start_date,
                'end_date' => $course->end_date,
            ]);
    }

    public function test_create_course()
    {
        $data = [
            'title' => mb_strtoupper('Curso de Programación en PHP'),
            'description' => mb_strtoupper('Introducción práctica al desarrollo backend con PHP.'),
            'start_date' => '2025-01-15',
            'end_date' => '2025-02-15'
        ];

        $response = $this->postJson('/api/courses', $data, $this->headers());

        $response->assertStatus(200);

        $this->assertDatabaseHas('courses', $data);
    }

    public function test_update_course()
    {
        $course = Course::create([
            'title' => 'Curso de Programación en PHP',
            'description' => 'Introducción práctica al desarrollo backend con PHP.',
            'start_date' => '2025-01-15',
            'end_date' => '2025-02-15'
        ]);

        $updateData = [
            'title' => mb_strtoupper('Curso de Programación en PHP 2'),
            'description' => mb_strtoupper('Introducción práctica al desarrollo backend con PHP 2.'),
            'start_date' => '2025-01-20',
            'end_date' => '2025-02-20'
        ];

        $response = $this->putJson("/api/courses/{$course->id}", $updateData, $this->headers());
        $response->assertStatus(200);

        $response = $this->getJson("/api/courses/{$course->id}", $this->headers());
        $response->assertStatus(200)
            ->assertJsonFragment($updateData);

        $this->assertDatabaseHas('courses', array_merge(['id' => $course->id], $updateData));
    }

    public function test_delete_course()
    {
        $course = Course::create([
            'title' => 'Curso de Programación en PHP',
            'description' => 'Introducción práctica al desarrollo backend con PHP.',
            'start_date' => '2025-01-15',
            'end_date' => '2025-02-15'
        ]);

        $response = $this->deleteJson(uri: "/api/courses/{$course->id}", headers: $this->headers());

        $response->assertStatus(200);

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}
