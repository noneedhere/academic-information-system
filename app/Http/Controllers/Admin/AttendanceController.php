<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    /**
     * Display a listing of all attendance records with filters.
     */
    public function index(Request $request): View
    {
        $query = Attendance::with(['student', 'teacher']);

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by student name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Filter by teacher
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        $attendances = $query->latest('date')
            ->latest('time')
            ->paginate(20)
            ->withQueryString();

        // Get teachers for filter dropdown
        $teachers = User::whereHas('role', fn ($q) => $q->where('slug', Role::TEACHER))
            ->orderBy('name')
            ->get();

        return view('admin.attendance.index', compact('attendances', 'teachers'));
    }
}
