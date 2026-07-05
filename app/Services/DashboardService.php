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
        // Today's attendance
        $todayAttendance = Attendance::where('student_id', $user->id)
            ->where('date', today())
            ->first();

        // Attendance stats
        $totalRecords = Attendance::where('student_id', $user->id)->count();
        $presentRecords = Attendance::where('student_id', $user->id)
            ->where('status', AttendanceStatus::Present)
            ->count();

        $attendancePercentage = $totalRecords > 0
            ? round(($presentRecords / $totalRecords) * 100, 1)
            : 0;

        // Monthly summary for current academic year (July to June)
        $now = now();
        $academicYearStart = $now->month >= 7
            ? Carbon::create($now->year, 7, 1)
            : Carbon::create($now->year - 1, 7, 1);

        $monthlySummary = [];
        for ($i = 0; $i < 12; $i++) {
            $month = $academicYearStart->copy()->addMonths($i);
            $monthAttendances = Attendance::where('student_id', $user->id)
                ->whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->get();

            if ($monthAttendances->isNotEmpty()) {
                $monthlySummary[] = [
                    'month'      => $month->format('F Y'),
                    'present'    => $monthAttendances->where('status', AttendanceStatus::Present)->count(),
                    'sick'       => $monthAttendances->where('status', AttendanceStatus::Sick)->count(),
                    'permission' => $monthAttendances->where('status', AttendanceStatus::Permission)->count(),
                    'absent'     => $monthAttendances->where('status', AttendanceStatus::Absent)->count(),
                ];
            }
        }

        // Calendar data for current month
        $calendarData = Attendance::where('student_id', $user->id)
            ->whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->get()
            ->mapWithKeys(function ($attendance) {
                return [$attendance->date->format('Y-m-d') => $attendance->status->value];
            })
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
