{{-- Teacher Dashboard Partial --}}
<div class="space-y-6">
    {{-- Stats Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        {{-- Today's Submissions --}}
        <div class="stat-card">
            <div class="stat-icon bg-primary-50 text-primary-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Today's Submissions</p>
                <p class="text-2xl font-bold text-gray-900">{{ $todaySubmissions }}</p>
            </div>
        </div>

        {{-- Quick Action --}}
        <div class="stat-card bg-gradient-to-br from-primary-500 to-accent-500 text-white border-0">
            <div class="stat-icon bg-white/20 text-white">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-white/80">Quick Action</p>
                <a href="{{ route('attendance.create') }}" class="text-lg font-bold hover:underline">
                    Record Attendance →
                </a>
            </div>
        </div>
    </div>

    {{-- Recent Records --}}
    <x-card title="Recent Attendance Records" subtitle="Your last 5 submissions" :padding="false">
        @if ($recentRecords->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentRecords as $record)
                            <tr>
                                <td class="font-medium">{{ $record->student->name }}</td>
                                <td>{{ $record->date->format('d M Y') }}</td>
                                <td class="font-mono text-xs">{{ $record->time }}</td>
                                <td><span class="badge-{{ $record->status->color() }}">{{ $record->status->label() }}</span></td>
                                <td class="text-gray-500 max-w-[200px] truncate">{{ $record->notes ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
                </svg>
                <p class="text-sm">No attendance records yet</p>
                <a href="{{ route('attendance.create') }}" class="btn-primary btn-sm mt-3 inline-flex">Record Attendance</a>
            </div>
        @endif
    </x-card>
</div>
