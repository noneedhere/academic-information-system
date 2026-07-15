<?php

namespace Database\Seeders;

use App\Enums\BillStatus;
use App\Models\Bill;
use App\Models\User;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
{
    /**
     * Seed sample bills for the demo student.
     */
    public function run(): void
    {
        $student = User::where('email', 'student@siakad.test')->first();

        if (!$student) {
            $this->command->warn('Skipping BillSeeder: demo student not found.');
            return;
        }

        $bills = [
            [
                'student_id'  => $student->id,
                'title'       => 'Tuition Fee — Semester 1',
                'description' => 'Academic tuition fee for the first semester 2026/2027.',
                'amount'      => 5500000,
                'due_date'    => now()->subMonths(2)->format('Y-m-d'),
                'status'      => BillStatus::Paid->value,
            ],
            [
                'student_id'  => $student->id,
                'title'       => 'Tuition Fee — Semester 2',
                'description' => 'Academic tuition fee for the second semester 2026/2027.',
                'amount'      => 5500000,
                'due_date'    => now()->addMonths(1)->format('Y-m-d'),
                'status'      => BillStatus::Unpaid->value,
            ],
            [
                'student_id'  => $student->id,
                'title'       => 'Laboratory Fee',
                'description' => 'Science and computer laboratory usage fee.',
                'amount'      => 750000,
                'due_date'    => now()->subWeeks(3)->format('Y-m-d'),
                'status'      => BillStatus::Paid->value,
            ],
            [
                'student_id'  => $student->id,
                'title'       => 'Library Membership',
                'description' => 'Annual library membership and resource access.',
                'amount'      => 200000,
                'due_date'    => now()->addWeeks(2)->format('Y-m-d'),
                'status'      => BillStatus::Unpaid->value,
            ],
            [
                'student_id'  => $student->id,
                'title'       => 'Exam Registration Fee',
                'description' => 'Final examination registration for current semester.',
                'amount'      => 350000,
                'due_date'    => now()->addMonths(2)->format('Y-m-d'),
                'status'      => BillStatus::Unpaid->value,
            ],
        ];

        foreach ($bills as $bill) {
            Bill::updateOrCreate(
                ['student_id' => $bill['student_id'], 'title' => $bill['title']],
                array_merge($bill, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        $this->command->info('Seeded ' . count($bills) . ' bills.');
    }
}
