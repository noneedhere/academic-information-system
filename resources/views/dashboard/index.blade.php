<x-layouts.app :title="'Dashboard'">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h1 class="page-title">Welcome, {{ $user->name }}!</h1>
                <p class="page-subtitle">{{ $currentDate }}</p>
            </div>
            <span class="badge-primary">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                {{ $roleName }}
            </span>
        </div>
    </div>

    {{-- Role-specific dashboard content --}}
    @if ($roleSlug === 'student')
        @include('dashboard.partials._student')
    @elseif ($roleSlug === 'teacher')
        @include('dashboard.partials._teacher')
    @elseif ($roleSlug === 'head_admin')
        @include('dashboard.partials._admin')
    @endif
</x-layouts.app>
