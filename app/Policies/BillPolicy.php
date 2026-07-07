<?php

namespace App\Policies;

use App\Models\Bill;
use App\Models\User;

class BillPolicy
{
    /**
     * Determine whether the user can view any bills.
     * Head Admin sees all, Student sees own.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isStudent();
    }

    /**
     * Determine whether the user can view the bill.
     * Head Admin (all), Student (own).
     */
    public function view(User $user, Bill $bill): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isStudent()) {
            return $bill->student_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create bills.
     * Head Admin only.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the bill.
     * Head Admin only.
     */
    public function update(User $user, Bill $bill): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the bill.
     * Head Admin only.
     */
    public function delete(User $user, Bill $bill): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can toggle the bill's payment status.
     * Head Admin only.
     */
    public function toggleStatus(User $user, Bill $bill): bool
    {
        return $user->isAdmin();
    }
}
