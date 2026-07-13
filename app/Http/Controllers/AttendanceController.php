<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Models\Attendance;
use App\Models\Role;
use App\Models\User;
use App\Services\AttendanceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function __construct(
        private AttendanceService $attendanceService,
    ) {}

    /**
     * Display a listing of the teacher's attendance records with filters.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Attendance::class);

        $user = Auth::user();

        $query = Attendance::where('teacher_id', $user->id)
            ->with('student');

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

        // Filter by student name
        if ($request->filled('search')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $attendances = $query->latest('date')
            ->latest('time')
            ->paginate(15)
            ->withQueryString();

        return view('attendance.index', compact('attendances'));
    }

    /**
     * Show the form for creating new attendance records (bulk form).
     */
    public function create(): View
    {
        $this->authorize('create', Attendance::class);

        $students = User::whereHas('role', fn ($q) => $q->where('slug', Role::STUDENT))
            ->orderBy('name')
            ->get();

        return view('attendance.create', compact('students'));
    }

    /**
     * Store newly created attendance records.
     */
    public function store(StoreAttendanceRequest $request): RedirectResponse
    {
        $this->authorize('create', Attendance::class);

        $this->attendanceService->storeAttendance(
            $request->validated('attendances'),
            Auth::id(),
            $request->validated('date'),
        );

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance records saved successfully.');
    }
}
