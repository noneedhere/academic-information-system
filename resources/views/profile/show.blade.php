<x-layouts.app :title="'My Profile'">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="page-title">My Profile</h1>
                <p class="page-subtitle">View your personal information</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                Edit Profile
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Profile Photo & Role Card --}}
        <div class="lg:col-span-1">
            <x-card>
                <div class="flex flex-col items-center text-center">
                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                         class="w-28 h-28 rounded-full object-cover ring-4 ring-primary-100 shadow-lg">
                    <h2 class="mt-4 text-lg font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500">{{ '@' . $user->username }}</p>
                    <span class="badge-primary mt-3">
                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.745 3.745 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                        </svg>
                        {{ $user->role->name }}
                    </span>
                    <p class="text-xs text-gray-400 mt-3">
                        Member since {{ $user->created_at->format('M d, Y') }}
                    </p>
                </div>
            </x-card>
        </div>

        {{-- Profile Details Card --}}
        <div class="lg:col-span-2">
            <x-card title="Personal Information" subtitle="Your account details">
                <div class="divide-y divide-gray-100">
                    {{-- Full Name --}}
                    <div class="flex flex-col sm:flex-row sm:items-center py-3.5 gap-1 sm:gap-0">
                        <div class="sm:w-1/3">
                            <p class="text-sm font-medium text-gray-500">Full Name</p>
                        </div>
                        <div class="sm:w-2/3">
                            <p class="text-sm text-gray-900">{{ $user->name }}</p>
                        </div>
                    </div>

                    {{-- Username --}}
                    <div class="flex flex-col sm:flex-row sm:items-center py-3.5 gap-1 sm:gap-0">
                        <div class="sm:w-1/3">
                            <p class="text-sm font-medium text-gray-500">Username</p>
                        </div>
                        <div class="sm:w-2/3">
                            <p class="text-sm text-gray-900">{{ $user->username }}</p>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="flex flex-col sm:flex-row sm:items-center py-3.5 gap-1 sm:gap-0">
                        <div class="sm:w-1/3">
                            <p class="text-sm font-medium text-gray-500">Email Address</p>
                        </div>
                        <div class="sm:w-2/3">
                            <p class="text-sm text-gray-900">{{ $user->email }}</p>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="flex flex-col sm:flex-row sm:items-center py-3.5 gap-1 sm:gap-0">
                        <div class="sm:w-1/3">
                            <p class="text-sm font-medium text-gray-500">Phone Number</p>
                        </div>
                        <div class="sm:w-2/3">
                            <p class="text-sm text-gray-900">{{ $user->phone ?? '—' }}</p>
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="flex flex-col sm:flex-row sm:items-center py-3.5 gap-1 sm:gap-0">
                        <div class="sm:w-1/3">
                            <p class="text-sm font-medium text-gray-500">Address</p>
                        </div>
                        <div class="sm:w-2/3">
                            <p class="text-sm text-gray-900">{{ $user->address ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.app>
