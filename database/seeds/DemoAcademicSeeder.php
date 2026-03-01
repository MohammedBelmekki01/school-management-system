<?php

use Illuminate\Database\Seeder;
use App\IClass;
use App\Section;
use App\Subject;

/**
 * DemoAcademicSeeder
 *
 * Seeds sample academic data (classes, sections, subjects)
 * for development and testing environments.
 * This seeder should NOT be run in production.
 *
 * @author Mohammed Belmekki
 */
class DemoAcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment('production')) {
            $this->command->warn('Skipping DemoAcademicSeeder in production environment.');
            return;
        }

        $this->command->info('Seeding demo academic data...');

        // Create sample classes
        $classes = [
            ['name' => 'Class 1', 'numeric_value' => 1, 'order' => 1, 'status' => '1'],
            ['name' => 'Class 2', 'numeric_value' => 2, 'order' => 2, 'status' => '1'],
            ['name' => 'Class 3', 'numeric_value' => 3, 'order' => 3, 'status' => '1'],
            ['name' => 'Class 4', 'numeric_value' => 4, 'order' => 4, 'status' => '1'],
            ['name' => 'Class 5', 'numeric_value' => 5, 'order' => 5, 'status' => '1'],
            ['name' => 'Class 6', 'numeric_value' => 6, 'order' => 6, 'status' => '1'],
            ['name' => 'Class 7', 'numeric_value' => 7, 'order' => 7, 'status' => '1'],
            ['name' => 'Class 8', 'numeric_value' => 8, 'order' => 8, 'status' => '1'],
            ['name' => 'Class 9', 'numeric_value' => 9, 'order' => 9, 'status' => '1'],
            ['name' => 'Class 10', 'numeric_value' => 10, 'order' => 10, 'status' => '1'],
        ];

        foreach ($classes as $classData) {
            $class = IClass::firstOrCreate(
                ['numeric_value' => $classData['numeric_value']],
                $classData
            );

            // Create sections A and B for each class
            foreach (['A', 'B'] as $sectionName) {
                Section::firstOrCreate(
                    ['name' => $sectionName, 'class_id' => $class->id],
                    [
                        'name'     => $sectionName,
                        'capacity' => 40,
                        'class_id' => $class->id,
                        'status'   => '1',
                    ]
                );
            }

            $this->command->info("  Created {$classData['name']} with sections.");
        }

        // Create common subjects for lower classes (1-5)
        $lowerSubjects = [
            ['name' => 'Mathematics', 'code' => 'MATH', 'type' => 1, 'order' => 1],
            ['name' => 'English', 'code' => 'ENG', 'type' => 1, 'order' => 2],
            ['name' => 'Science', 'code' => 'SCI', 'type' => 1, 'order' => 3],
            ['name' => 'Social Studies', 'code' => 'SOC', 'type' => 1, 'order' => 4],
            ['name' => 'Arabic', 'code' => 'ARB', 'type' => 1, 'order' => 5],
        ];

        // Create subjects for higher classes (6-10)
        $higherSubjects = [
            ['name' => 'Mathematics', 'code' => 'MATH', 'type' => 1, 'order' => 1],
            ['name' => 'English', 'code' => 'ENG', 'type' => 1, 'order' => 2],
            ['name' => 'Physics', 'code' => 'PHY', 'type' => 1, 'order' => 3],
            ['name' => 'Chemistry', 'code' => 'CHM', 'type' => 1, 'order' => 4],
            ['name' => 'Biology', 'code' => 'BIO', 'type' => 2, 'order' => 5],
            ['name' => 'Computer Science', 'code' => 'CS', 'type' => 2, 'order' => 6],
            ['name' => 'Arabic', 'code' => 'ARB', 'type' => 1, 'order' => 7],
        ];

        $allClasses = IClass::orderBy('numeric_value')->get();

        foreach ($allClasses as $class) {
            $subjects = $class->numeric_value <= 5 ? $lowerSubjects : $higherSubjects;

            foreach ($subjects as $subjectData) {
                Subject::firstOrCreate(
                    ['code' => $subjectData['code'], 'class_id' => $class->id],
                    array_merge($subjectData, [
                        'class_id' => $class->id,
                        'status'   => '1',
                    ])
                );
            }
        }

        $this->command->info('Demo academic data seeded successfully!');
    }
}
