<x-layouts.app :title="'Attendance Records'">
    {{-- Page Header --}}
    <div class="page-header">
        <h1 class="page-title">Attendance Records</h1>
        <p class="page-subtitle">View all attendance records across the system</p>
    </div>

    {{-- Filters --}}
    <x-card class="mb-6">
        <form method="GET" action="{{ route('admin.attendance.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
            <div class="form-group">
                <label for="date_from" class="form-label">From Date</label>
                <input id="date_from" type="date" name="date_from" value="{{ request('date_from') }}" class="form-input">
            </div>
            <div class="form-group">
                <label for="date_to" class="form-label">To Date</label>
                <input id="date_to" type="date" name="date_to" value="{{ request('date_to') }}" class="form-input">
            </div>
            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach (App\Enums\AttendanceStatus::cases() as $status)
                        <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="teacher_id" class="form-label">Teacher</label>
                <select id="teacher_id" name="teacher_id" class="form-select">
                    <option value="">All Teachers</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="search" class="form-label">Search Student</label>
                <input id="search" type="text" name="search" value="{{ request('search') }}"
                       class="form-input" placeholder="Student name...">
            </div>
            <div class="form-group flex items-end gap-2">
                <button type="submit" class="btn-primary flex-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    Filter
                </button>
                @if (request()->hasAny(['date_from', 'date_to', 'status', 'teacher_id', 'search']))
                    <a href="{{ route('admin.attendance.index') }}" class="btn-ghost">Clear</a>
                @endif
            </div>
        </form>
    </x-card>

    {{-- Table --}}
    <x-card :padding="false">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Teacher</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $attendance)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <img src="{{ $attendance->student->profile_photo_url }}" alt="{{ $attendance->student->name }}"
                                         class="w-8 h-8 rounded-full object-cover">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $attendance->student->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $attendance->student->username }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <img src="{{ $attendance->teacher->profile_photo_url }}" alt="{{ $attendance->teacher->name }}"
                                         class="w-6 h-6 rounded-full object-cover">
                                    <span class="text-sm text-gray-700">{{ $attendance->teacher->name }}</span>
                                </div>
                            </td>
                            <td>{{ $attendance->date->format('d M Y') }}</td>
                            <td class="font-mono text-xs">{{ $attendance->time }}</td>
                            <td>
                                <span class="badge-{{ $attendance->status->color() }}">
                                    {{ $attendance->status->label() }}
                                </span>
                            </td>
                            <td class="text-sm text-gray-500 max-w-xs truncate">{{ $attendance->notes ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                </svg>
                                <p class="text-gray-500 font-medium">No attendance records found</p>
                                <p class="text-sm text-gray-400 mt-1">Try adjusting your filters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    {{-- Pagination --}}
    @if ($attendances->hasPages())
        <div class="pagination-wrapper mt-6">
            {{ $attendances->links() }}
        </div>
    @endif
</x-layouts.app>
