<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;

class AttendancePolicy
{
    /**
     * Determine whether the user can view any attendance records.
     * Teachers see their own, Head Admin sees all, Students see own.
     */
    public function viewAny(User $user): bool
    {
        return $user->isTeacher() || $user->isAdmin() || $user->isStudent();
    }

    /**
     * Determine whether the user can view the attendance record.
     * Teacher (own records), Head Admin (all), Student (own).
     */
    public function view(User $user, Attendance $attendance): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isTeacher()) {
            return $attendance->teacher_id === $user->id;
        }

        if ($user->isStudent()) {
            return $attendance->student_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create attendance records.
     * Teachers only.
     */
    public function create(User $user): bool
    {
        return $user->isTeacher();
    }

    /**
     * Determine whether the user can update the attendance record.
     * Teacher (own records) only.
     */
    public function update(User $user, Attendance $attendance): bool
    {
        if ($user->isTeacher()) {
            return $attendance->teacher_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the attendance record.
     * Head Admin only.
     */
    public function delete(User $user, Attendance $attendance): bool
    {
        return $user->isAdmin();
    }
}
