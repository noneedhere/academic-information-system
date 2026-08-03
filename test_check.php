<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Attendance;
use App\Models\Bill;

echo "=== USERS AND RELATED DATA ===\n";
$users = User::with('role')->get();
foreach ($users as $u) {
    $attCount = $u->attendances()->count();
    $billCount = $u->bills()->count();
    echo $u->role->slug . ': ' . $u->name . ' | att=' . $attCount . ' bills=' . $billCount . "\n";
}

echo "\n=== ATTENDANCE RECORDS (sample 5) ===\n";
$attendances = Attendance::with(['student', 'teacher'])->take(5)->get();
foreach ($attendances as $a) {
    echo 'Student: ' . $a->student->name . ' | Teacher: ' . $a->teacher->name . ' | Date: ' . $a->date . ' | Status: ' . $a->status->value . "\n";
}

echo "\n=== BILLS (sample 5) ===\n";
$bills = Bill::with('student')->take(5)->get();
foreach ($bills as $b) {
    echo 'Student: ' . $b->student->name . ' | Title: ' . $b->title . ' | Status: ' . $b->status->value . "\n";
}

echo "\n=== POLICY TEST: Can admin delete student with data? ===\n";
$admin = User::whereHas('role', fn($q) => $q->where('slug', 'head_admin'))->first();
$studentWithData = User::whereHas('role', fn($q) => $q->where('slug', 'student'))
    ->whereHas('attendances')
    ->first();
if ($studentWithData) {
    $hasAtt = $studentWithData->attendances()->exists();
    $hasBills = $studentWithData->bills()->exists();
    echo 'Student: ' . $studentWithData->name . " | hasAttendance: " . ($hasAtt ? 'YES' : 'NO') . " | hasBills: " . ($hasBills ? 'YES' : 'NO') . "\n";
    echo "Destroy should: " . ($hasAtt || $hasBills ? 'BLOCK and return error message' : 'ALLOW deletion') . "\n";
} else {
    echo "No student with attendance data found\n";
}

echo "\n=== AttendanceService getStudentStats TEST ===\n";
$student = User::whereHas('role', fn($q) => $q->where('slug', 'student'))->first();
if ($student) {
    $service = app(App\Services\AttendanceService::class);
    $stats = $service->getStudentStats($student->id);
    echo 'Student: ' . $student->name . "\n";
    print_r($stats);
}

echo "\nALL TESTS PASSED\n";
