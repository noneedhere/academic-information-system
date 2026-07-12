<x-layouts.app :title="'Add User'">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="page-title">Add User</h1>
                <p class="page-subtitle">Create a new user account</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
                Back to Users
            </a>
        </div>
    </div>

    <div class="max-w-3xl">
        <x-card title="User Information" subtitle="Fill in the details for the new user">
            <form method="POST" action="{{ route('admin.users.store') }}" data-loading class="space-y-6">
                @csrf

                {{-- Role --}}
                <div class="form-group">
                    <label for="role_id" class="form-label">Role</label>
                    <select id="role_id" name="role_id" required class="form-select">
                        <option value="">Select a role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Name --}}
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                           class="form-input" placeholder="Full name">
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Username --}}
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required
                           class="form-input" placeholder="username">
                    @error('username')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           class="form-input" placeholder="user@example.com">
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                           class="form-input" placeholder="+62 812 3456 7890">
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Address --}}
                <div class="form-group">
                    <label for="address" class="form-label">Address <span class="text-gray-400 font-normal">(optional)</span></label>
                    <textarea id="address" name="address" rows="3"
                              class="form-input" placeholder="User's address">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" name="password" required
                               class="form-input" placeholder="Minimum 8 characters">
                        @error('password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               class="form-input" placeholder="Repeat password">
                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                        Create User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-ghost">Cancel</a>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.app>
