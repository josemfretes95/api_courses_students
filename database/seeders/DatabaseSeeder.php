<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::beginTransaction();

        // USER
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'admin' => true,
        ]);

        // COURSES
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
            ],
            [
                'title' => 'Curso de Laravel Avanzado',
                'description' => 'Conceptos avanzados del framework Laravel para proyectos reales.',
                'start_date' => '2025-07-05',
                'end_date' => '2025-08-20'
            ],
            [
                'title' => 'Curso de JavaScript Moderno',
                'description' => 'Desde fundamentos hasta ES2025 con ejercicios prácticos.',
                'start_date' => '2025-02-18',
                'end_date' => '2025-04-01'
            ],
            [
                'title' => 'Curso de Python para Principiantes',
                'description' => 'Primeros pasos con Python, sintaxis y lógica.',
                'start_date' => '2025-05-12',
                'end_date' => '2025-06-12'
            ],
            [
                'title' => 'Curso de Inteligencia Artificial',
                'description' => 'Fundamentos de IA, machine learning y redes neuronales.',
                'start_date' => '2025-09-01',
                'end_date' => '2025-11-01'
            ],
            [
                'title' => 'Curso de Diseño UX/UI',
                'description' => 'Diseño centrado en el usuario con herramientas actuales.',
                'start_date' => '2025-03-20',
                'end_date' => '2025-04-20'
            ],
            [
                'title' => 'Curso de Seguridad Informática',
                'description' => 'Conceptos esenciales de ciberseguridad y prácticas seguras.',
                'start_date' => '2025-06-18',
                'end_date' => '2025-08-18'
            ],
            [
                'title' => 'Curso de Administración de Servidores Linux',
                'description' => 'Gestión y configuración de servidores con Linux.',
                'start_date' => '2025-10-10',
                'end_date' => '2025-12-10'
            ]
        ];
        Course::insert($courses);

        // STUDENTS
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
            ],
            [
                'name' => 'Diego Martínez',
                'email' => 'diego.mtz@example.com',
                'birthday' => '1989-09-18',
                'nationality' => 'peruana'
            ],
            [
                'name' => 'Sofía Benítez',
                'email' => 'sofia.benitez@example.com',
                'birthday' => '1997-02-14',
                'nationality' => 'boliviana'
            ],
            [
                'name' => 'Andrés López',
                'email' => 'andres.lopez@example.com',
                'birthday' => '1993-06-30',
                'nationality' => 'mexicana'
            ],
            [
                'name' => 'Valentina Duarte',
                'email' => 'valentina.duarte@example.com',
                'birthday' => '2000-04-22',
                'nationality' => 'colombiana'
            ],
            [
                'name' => 'Esteban Rivas',
                'email' => 'esteban.rivas@example.com',
                'birthday' => '1991-12-09',
                'nationality' => 'venezolana'
            ],
            [
                'name' => 'Camila Ortiz',
                'email' => 'camila.ortiz@example.com',
                'birthday' => '1996-08-17',
                'nationality' => 'ecuatoriana'
            ],
            [
                'name' => 'Rodrigo Silva',
                'email' => 'rodrigo.silva@example.com',
                'birthday' => '1994-05-03',
                'nationality' => 'brasileña'
            ]
        ];

        Student::insert($students);

        // ENROLLMENTS
        $enrollments = [
            [
                'student_id' => 1,
                'course_id' => 1,
                'enrolled_at' => '2025-12-05 07:10:10'
            ],
            [
                'student_id' => 1,
                'course_id' => 2,
                'enrolled_at' => '2025-12-05 07:10:20'
            ],
            [
                'student_id' => 1,
                'course_id' => 3,
                'enrolled_at' => '2025-12-05 07:10:30'
            ],
            [
                'student_id' => 2,
                'course_id' => 1,
                'enrolled_at' => '2025-12-05 07:10:40'
            ],
            [
                'student_id' => 3,
                'course_id' => 1,
                'enrolled_at' => '2025-12-05 07:10:50'
            ],
        ];
        Enrollment::insert($enrollments);

        DB::commit();
    }
}
