<?php

namespace App\Services;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AttendanceService
{
    /**
     * Store attendance records for multiple students on a given date.
     *
     * @param  array<int, array{student_id: int, status: string, notes: string|null}>  $attendances
     * @param  int  $teacherId
     * @param  string  $date
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeAttendance(array $attendances, int $teacherId, string $date): void
    {
        $errors = [];
        $time = now()->format('H:i:s');

        // Validate all students exist and have student role
        foreach ($attendances as $index => $entry) {
            $student = User::find($entry['student_id']);

            if (!$student || !$student->isStudent()) {
                $errors["attendances.{$index}.student_id"] = 'Invalid student selected.';
                continue;
            }

            // Check for duplicate attendance
            $exists = Attendance::where('student_id', $entry['student_id'])
                ->where('date', $date)
                ->exists();

            if ($exists) {
                $errors["attendances.{$index}.student_id"] =
                    "Attendance for {$student->name} on this date has already been recorded.";
            }
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }

        // Store all records in a transaction
        DB::transaction(function () use ($attendances, $teacherId, $date, $time) {
            foreach ($attendances as $entry) {
                Attendance::create([
                    'student_id' => $entry['student_id'],
                    'teacher_id' => $teacherId,
                    'date'       => $date,
                    'time'       => $time,
                    'status'     => $entry['status'],
                    'notes'      => $entry['notes'] ?? null,
                ]);
            }
        });
    }

    /**
     * Calculate attendance percentage for a student.
     * Formula: (present records / total records) × 100, rounded to 1 decimal.
     */
    public function getAttendancePercentage(int $studentId): float
    {
        $total = Attendance::where('student_id', $studentId)->count();

        if ($total === 0) {
            return 0;
        }

        $present = Attendance::where('student_id', $studentId)
            ->where('status', AttendanceStatus::Present)
            ->count();

        return round(($present / $total) * 100, 1);
    }
}
