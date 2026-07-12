{{-- Admin Dashboard Partial --}}
<div class="space-y-6">
    {{-- Stats Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        {{-- Users --}}
        <div class="stat-card">
            <div class="stat-icon bg-primary-50 text-primary-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Users</p>
                <p class="text-2xl font-bold text-gray-900">{{ $adminCount + $teacherCount + $studentCount }}</p>
                <div class="flex gap-2 mt-1 text-xs text-gray-400">
                    <span>{{ $adminCount }} admin</span>
                    <span>·</span>
                    <span>{{ $teacherCount }} teachers</span>
                    <span>·</span>
                    <span>{{ $studentCount }} students</span>
                </div>
            </div>
        </div>

        {{-- Today's Attendance --}}
        <div class="stat-card">
            <div class="stat-icon bg-emerald-50 text-emerald-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Today's Attendance</p>
                <p class="text-2xl font-bold text-gray-900">{{ $todayAttendanceCount }}</p>
                <p class="text-xs text-gray-400 mt-1">records submitted today</p>
            </div>
        </div>

        {{-- Bills Overview --}}
        <div class="stat-card">
            <div class="stat-icon bg-amber-50 text-amber-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Bills</p>
                <p class="text-2xl font-bold text-gray-900">{{ $paidBills + $unpaidBills }}</p>
                <div class="flex gap-2 mt-1 text-xs text-gray-400">
                    <span class="text-emerald-600">{{ $paidBills }} paid</span>
                    <span>·</span>
                    <span class="text-amber-600">{{ $unpaidBills }} unpaid</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <x-card title="Quick Actions" subtitle="Frequently used actions">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <a href="{{ route('admin.users.create') }}"
               class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Add User</p>
                    <p class="text-xs text-gray-500">Create new account</p>
                </div>
            </a>

            <a href="{{ route('admin.bills.create') }}"
               class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50/50 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Create Bill</p>
                    <p class="text-xs text-gray-500">New student billing</p>
                </div>
            </a>

            <a href="{{ route('admin.attendance.index') }}"
               class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-amber-300 hover:bg-amber-50/50 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">View Attendance</p>
                    <p class="text-xs text-gray-500">All records</p>
                </div>
            </a>
        </div>
    </x-card>
</div>
