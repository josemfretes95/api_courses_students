<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Enrollment;

class EnrollmentsTest extends TestCase
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

    public function test_list_enrollments()
    {
        $course1 = Course::create([
            'title' => 'Curso de Programación en PHP',
            'description' => 'Introducción práctica al desarrollo backend con PHP.',
            'start_date' => '2025-01-15',
            'end_date' => '2025-02-15'
        ]);

        $course2 = Course::create([
            'title' => 'Curso de Desarrollo Web Full Stack',
            'description' => 'Aprende frontend y backend con tecnologías modernas.',
            'start_date' => '2025-03-01',
            'end_date' => '2025-06-01'
        ]);

        $student1 = Student::create([
            'name' => 'María González',
            'email' => 'maria.gonzalez@example.com',
            'birthday' => '1995-03-12',
            'nationality' => 'argentina'
        ]);

        $student2 = Student::create([
            'name' => 'Carlos Romero',
            'email' => 'c.romero92@example.com',
            'birthday' => '1992-07-25',
            'nationality' => 'chilena'
        ]);

        $enrollment1 = Enrollment::create([
            'course_id' => $course1->id,
            'student_id' => $student1->id,
            'enrolled_at' => '2025-12-05 01:02:03',
        ]);

        $enrollment2 = Enrollment::create([
            'course_id' => $course1->id,
            'student_id' => $student2->id,
            'enrolled_at' => '2025-12-05 01:02:04',
        ]);

        $enrollment3 = Enrollment::create([
            'course_id' => $course2->id,
            'student_id' => $student1->id,
            'enrolled_at' => '2025-12-05 01:02:05',
        ]);

        $enrollment4 = Enrollment::create([
            'course_id' => $course2->id,
            'student_id' => $student2->id,
            'enrolled_at' => '2025-12-05 01:02:06',
        ]);

        $page = 2;
        $limit = 1;
        $response = $this->getJson("/api/enrollments?student_id={$student1->id}&page={$page}&limit={$limit}&sort=desc", $this->headers());

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'student_id',
                        'course_id',
                        'enrolled_at',
                    ],
                ],
                'meta' => [
                    'current_page',
                    'per_page',
                    'total',
                    'last_page',
                ],
            ]);

        $response->assertJson([
            'data' => [
                [
                    'id' => $enrollment1->id,
                    'student_id' => $enrollment1->student_id,
                    'course_id' => $enrollment1->course_id,
                    'enrolled_at' => '2025-12-05 01:02:03',
                ],
            ],
            'meta' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total' => 2,
                'last_page' => 2,
            ],
        ]);
    }

    public function test_create_enrollment()
    {
        $course = Course::create([
            'title' => 'Curso de Programación en PHP',
            'description' => 'Introducción práctica al desarrollo backend con PHP.',
            'start_date' => '2025-01-15',
            'end_date' => '2025-02-15'
        ]);

        $student = Student::create([
            'name' => 'María González',
            'email' => 'maria.gonzalez@example.com',
            'birthday' => '1995-03-12',
            'nationality' => 'argentina'
        ]);

        $data = [
            'course_id' => $course->id,
            'student_id' => $student->id,
            'enrolled_at' => '2025-12-05 01:02:03',
        ];

        $response = $this->postJson('/api/enrollments', $data, $this->headers());

        $response->assertStatus(200);

        $this->assertDatabaseHas('enrollments', $data);
    }

    public function test_delete_enrollment()
    {
        $course = Course::create([
            'title' => 'Curso de Programación en PHP',
            'description' => 'Introducción práctica al desarrollo backend con PHP.',
            'start_date' => '2025-01-15',
            'end_date' => '2025-02-15'
        ]);

        $student = Student::create([
            'name' => 'María González',
            'email' => 'maria.gonzalez@example.com',
            'birthday' => '1995-03-12',
            'nationality' => 'argentina'
        ]);

        $enrollment = Enrollment::create([
            'course_id' => $course->id,
            'student_id' => $student->id,
            'enrolled_at' => '2025-12-05 01:02:03',
        ]);

        $response = $this->deleteJson(uri: "/api/enrollments/{$enrollment->id}", headers: $this->headers());

        $response->assertStatus(200);

        $this->assertDatabaseMissing('enrollments', ['id' => $enrollment->id]);
    }
}
