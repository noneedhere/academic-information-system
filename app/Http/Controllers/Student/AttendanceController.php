<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function __construct(
        private AttendanceService $attendanceService,
    ) {}

    /**
     * Display the student's own attendance records with filters.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Attendance::class);

        $user = Auth::user();

        $request->validate([
            'date_from' => ['nullable', 'date', 'date_format:Y-m-d'],
            'date_to'   => ['nullable', 'date', 'date_format:Y-m-d'],
            'status'    => ['nullable', 'in:present,sick,permission,absent'],
        ]);

        $query = Attendance::where('student_id', $user->id)
            ->with('teacher');

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

        $attendances = $query->latest('date')
            ->latest('time')
            ->paginate(15)
            ->withQueryString();

        // Summary stats (delegated to service — single source of truth)
        $stats = $this->attendanceService->getStudentStats($user->id);

        return view('student.attendance.index', array_merge(
            compact('attendances'),
            $stats,
        ));
    }
}
