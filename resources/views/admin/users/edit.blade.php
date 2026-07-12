<x-layouts.app :title="'Edit User'">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="page-title">Edit User</h1>
                <p class="page-subtitle">Update information for {{ $user->name }}</p>
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
        <x-card title="User Information" subtitle="Update the user's account details">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" data-loading class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Role --}}
                <div class="form-group">
                    <label for="role_id" class="form-label">Role</label>
                    <select id="role_id" name="role_id" required class="form-select">
                        <option value="">Select a role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
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
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="form-input" placeholder="Full name">
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Username --}}
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username', $user->username) }}" required
                           class="form-input" placeholder="username">
                    @error('username')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="form-input" placeholder="user@example.com">
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="form-input" placeholder="+62 812 3456 7890">
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Address --}}
                <div class="form-group">
                    <label for="address" class="form-label">Address <span class="text-gray-400 font-normal">(optional)</span></label>
                    <textarea id="address" name="address" rows="3"
                              class="form-input" placeholder="User's address">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password (optional on edit) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="password" class="form-label">New Password <span class="text-gray-400 font-normal">(leave blank to keep current)</span></label>
                        <input id="password" type="password" name="password"
                               class="form-input" placeholder="Minimum 8 characters">
                        @error('password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               class="form-input" placeholder="Repeat new password">
                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        Update User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-ghost">Cancel</a>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.app>
