<?php

namespace App\Services;

use App\Enums\AttendanceStatus;
use App\Enums\BillStatus;
use App\Models\Attendance;
use App\Models\Bill;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    /**
     * Get dashboard data for the authenticated user based on their role.
     *
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        $user = Auth::user();
        $common = $this->getCommonData($user);

        return match ($user->role->slug) {
            Role::STUDENT    => array_merge($common, $this->getStudentData($user)),
            Role::TEACHER    => array_merge($common, $this->getTeacherData($user)),
            Role::HEAD_ADMIN => array_merge($common, $this->getAdminData()),
        };
    }

    /**
     * Get common dashboard data (welcome message, date, etc.).
     *
     * @return array<string, mixed>
     */
    private function getCommonData(User $user): array
    {
        return [
            'user'        => $user,
            'currentDate' => now()->translatedFormat('l, j F Y'),
            'roleName'    => $user->role->name,
            'roleSlug'    => $user->role->slug,
        ];
    }

    /**
     * Get student-specific dashboard data.
     *
     * @return array<string, mixed>
     */
    private function getStudentData(User $user): array
    {
        $now = now();

        // Academic year boundaries (July to June)
        $academicYearStart = $now->month >= 7
            ? Carbon::create($now->year, 7, 1)
            : Carbon::create($now->year - 1, 7, 1);
        $academicYearEnd = $academicYearStart->copy()->addYear()->subDay();

        // Single query: fetch ALL attendance records for this student in the academic year
        $allAttendances = Attendance::where('student_id', $user->id)
            ->whereBetween('date', [$academicYearStart, $academicYearEnd])
            ->get();

        // Today's attendance (filter from already-loaded collection)
        $todayAttendance = $allAttendances->firstWhere('date', today());

        // Overall stats (from collection, no extra queries)
        $totalRecords = $allAttendances->count();
        $presentRecords = $allAttendances->where('status', AttendanceStatus::Present)->count();
        $attendancePercentage = $totalRecords > 0
            ? round(($presentRecords / $totalRecords) * 100, 1)
            : 0;

        // Monthly summary (group by month from the collection — no loop queries)
        $monthlySummary = $allAttendances
            ->groupBy(fn ($a) => $a->date->format('Y-m'))
            ->sortKeys()
            ->map(function ($monthRecords, $monthKey) {
                return [
                    'month'      => Carbon::createFromFormat('Y-m', $monthKey)->format('F Y'),
                    'present'    => $monthRecords->where('status', AttendanceStatus::Present)->count(),
                    'sick'       => $monthRecords->where('status', AttendanceStatus::Sick)->count(),
                    'permission' => $monthRecords->where('status', AttendanceStatus::Permission)->count(),
                    'absent'     => $monthRecords->where('status', AttendanceStatus::Absent)->count(),
                ];
            })
            ->values()
            ->toArray();

        // Calendar data for current month (filter from collection)
        $calendarData = $allAttendances
            ->filter(fn ($a) => $a->date->year === $now->year && $a->date->month === $now->month)
            ->mapWithKeys(fn ($a) => [$a->date->format('Y-m-d') => $a->status->value])
            ->toArray();

        return [
            'todayAttendance'      => $todayAttendance,
            'totalRecords'         => $totalRecords,
            'presentRecords'       => $presentRecords,
            'attendancePercentage' => $attendancePercentage,
            'monthlySummary'       => $monthlySummary,
            'calendarData'         => $calendarData,
            'calendarMonth'        => $now->format('F Y'),
            'calendarYear'         => $now->year,
            'calendarMonthNum'     => $now->month,
        ];

    }

    /**
     * Get teacher-specific dashboard data.
     *
     * @return array<string, mixed>
     */
    private function getTeacherData(User $user): array
    {
        $todayCount = Attendance::where('teacher_id', $user->id)
            ->where('date', today())
            ->count();

        $recentRecords = Attendance::where('teacher_id', $user->id)
            ->with('student')
            ->latest('date')
            ->latest('time')
            ->limit(5)
            ->get();

        return [
            'todaySubmissions' => $todayCount,
            'recentRecords'    => $recentRecords,
        ];
    }

    /**
     * Get head admin-specific dashboard data.
     *
     * @return array<string, mixed>
     */
    private function getAdminData(): array
    {
        $adminCount   = User::whereHas('role', fn ($q) => $q->where('slug', Role::HEAD_ADMIN))->count();
        $teacherCount = User::whereHas('role', fn ($q) => $q->where('slug', Role::TEACHER))->count();
        $studentCount = User::whereHas('role', fn ($q) => $q->where('slug', Role::STUDENT))->count();

        $todayAttendanceCount = Attendance::where('date', today())->count();

        $paidBills   = Bill::where('status', BillStatus::Paid)->count();
        $unpaidBills = Bill::where('status', BillStatus::Unpaid)->count();

        return [
            'adminCount'           => $adminCount,
            'teacherCount'         => $teacherCount,
            'studentCount'         => $studentCount,
            'todayAttendanceCount' => $todayAttendanceCount,
            'paidBills'            => $paidBills,
            'unpaidBills'          => $unpaidBills,
        ];
    }
}
