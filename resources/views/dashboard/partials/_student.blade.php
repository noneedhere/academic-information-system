{{-- Student Dashboard Partial --}}
<div class="space-y-6">
    {{-- Stats Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Today's Status --}}
        <div class="stat-card">
            <div class="stat-icon bg-primary-50 text-primary-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Today's Status</p>
                @if ($todayAttendance)
                    <span class="badge-{{ $todayAttendance->status->color() }} mt-1">{{ $todayAttendance->status->label() }}</span>
                @else
                    <p class="text-lg font-bold text-gray-400">Not recorded</p>
                @endif
            </div>
        </div>

        {{-- Total Records --}}
        <div class="stat-card">
            <div class="stat-icon bg-accent-400/10 text-accent-500">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Records</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalRecords }}</p>
            </div>
        </div>

        {{-- Present Count --}}
        <div class="stat-card">
            <div class="stat-icon bg-emerald-50 text-emerald-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Present Days</p>
                <p class="text-2xl font-bold text-gray-900">{{ $presentRecords }}</p>
            </div>
        </div>

        {{-- Attendance Rate --}}
        <div class="stat-card">
            <div class="stat-icon bg-amber-50 text-amber-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Attendance Rate</p>
                <p class="text-2xl font-bold {{ $attendancePercentage >= 75 ? 'text-emerald-600' : 'text-red-600' }}">
                    {{ $attendancePercentage }}%
                </p>
            </div>
        </div>
    </div>

    {{-- Monthly Summary & Calendar --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Monthly Summary Table --}}
        <x-card title="Monthly Summary" subtitle="Academic year attendance breakdown">
            @if (count($monthlySummary) > 0)
                <div class="overflow-x-auto -mx-5 -mb-5">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th class="text-center">Present</th>
                                <th class="text-center">Sick</th>
                                <th class="text-center">Permission</th>
                                <th class="text-center">Absent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($monthlySummary as $month)
                                <tr>
                                    <td class="font-medium">{{ $month['month'] }}</td>
                                    <td class="text-center"><span class="badge-emerald">{{ $month['present'] }}</span></td>
                                    <td class="text-center"><span class="badge-amber">{{ $month['sick'] }}</span></td>
                                    <td class="text-center"><span class="badge-sky">{{ $month['permission'] }}</span></td>
                                    <td class="text-center"><span class="badge-red">{{ $month['absent'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    <p class="text-sm">No attendance data yet</p>
                </div>
            @endif
        </x-card>

        {{-- Attendance Calendar --}}
        <x-card title="Attendance Calendar" :subtitle="$calendarMonth">
            @php
                $firstDay = \Carbon\Carbon::create($calendarYear, $calendarMonthNum, 1);
                $daysInMonth = $firstDay->daysInMonth;
                $startDow = $firstDay->dayOfWeek; // 0=Sunday
            @endphp
            <div class="grid grid-cols-7 gap-1 text-center">
                @foreach (['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
                    <div class="text-xs font-semibold text-gray-400 py-1">{{ $day }}</div>
                @endforeach

                {{-- Empty cells before 1st --}}
                @for ($i = 0; $i < $startDow; $i++)
                    <div></div>
                @endfor

                {{-- Day cells --}}
                @for ($d = 1; $d <= $daysInMonth; $d++)
                    @php
                        $dateKey = sprintf('%04d-%02d-%02d', $calendarYear, $calendarMonthNum, $d);
                        $status = $calendarData[$dateKey] ?? null;
                        $colorMap = [
                            'present'    => 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-300',
                            'sick'       => 'bg-amber-100 text-amber-700 ring-1 ring-amber-300',
                            'permission' => 'bg-sky-100 text-sky-700 ring-1 ring-sky-300',
                            'absent'     => 'bg-red-100 text-red-700 ring-1 ring-red-300',
                        ];
                        $cls = $status ? $colorMap[$status] : 'text-gray-600 hover:bg-gray-50';
                        $isToday = $dateKey === now()->format('Y-m-d');
                    @endphp
                    <div class="aspect-square flex items-center justify-center rounded-lg text-xs font-medium {{ $cls }} {{ $isToday ? 'ring-2 ring-primary-400' : '' }}"
                         @if ($status) title="{{ ucfirst($status) }}" @endif>
                        {{ $d }}
                    </div>
                @endfor
            </div>

            {{-- Legend --}}
            <div class="flex flex-wrap gap-3 mt-4 pt-4 border-t border-gray-100 text-xs text-gray-500">
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-emerald-200"></span> Present</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-amber-200"></span> Sick</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-sky-200"></span> Permission</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-red-200"></span> Absent</span>
            </div>
        </x-card>
    </div>
</div>
