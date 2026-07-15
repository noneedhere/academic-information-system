<?php

namespace Database\Seeders;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Seed attendance records for the demo student.
     * Creates ~30 days of records using the demo teacher.
     */
    public function run(): void
    {
        $student = User::where('email', 'student@siakad.test')->first();
        $teacher = User::where('email', 'teacher@siakad.test')->first();

        if (!$student || !$teacher) {
            $this->command->warn('Skipping AttendanceSeeder: demo student or teacher not found.');
            return;
        }

        // Weighted status pool: 70% Present, 10% Sick, 10% Permission, 10% Absent
        $statusPool = array_merge(
            array_fill(0, 7, AttendanceStatus::Present),
            [AttendanceStatus::Sick, AttendanceStatus::Permission, AttendanceStatus::Absent],
        );

        $notesPool = [
            AttendanceStatus::Present->value    => [null, null, null, 'On time', 'Arrived early'],
            AttendanceStatus::Sick->value       => ['Flu symptoms', 'Headache', 'Doctor appointment'],
            AttendanceStatus::Permission->value => ['Family event', 'Personal matters', 'Official leave'],
            AttendanceStatus::Absent->value     => ['No notification', null, 'Unexcused'],
        ];

        $startDate = now()->subDays(30);
        $records = [];

        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i);

            // Skip weekends
            if ($date->isWeekend()) {
                continue;
            }

            $status = $statusPool[array_rand($statusPool)];
            $notes = $notesPool[$status->value];

            $records[] = [
                'student_id' => $student->id,
                'teacher_id' => $teacher->id,
                'date'       => $date->format('Y-m-d'),
                'time'       => sprintf('%02d:%02d:00', rand(7, 8), rand(0, 59)),
                'status'     => $status->value,
                'notes'      => $notes[array_rand($notes)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Use upsert to avoid duplicate key errors on re-seed
        foreach ($records as $record) {
            Attendance::updateOrCreate(
                ['student_id' => $record['student_id'], 'date' => $record['date']],
                $record
            );
        }

        $this->command->info('Seeded ' . count($records) . ' attendance records.');
    }
}
