<x-layouts.app :title="'Settings'">
    {{-- Page Header --}}
    <div class="page-header">
        <h1 class="page-title">Settings</h1>
        <p class="page-subtitle">Manage your account security</p>
    </div>

    <div class="max-w-2xl">
        <x-card title="Change Password" subtitle="Ensure your account stays secure by using a strong password">
            <form method="POST" action="{{ route('settings.password') }}" data-loading class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Current Password --}}
                <div class="form-group">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input id="current_password" type="password" name="current_password" required
                           class="form-input" placeholder="Enter current password">
                    @error('current_password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New Password --}}
                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <input id="password" type="password" name="password" required
                           class="form-input" placeholder="Enter new password">
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-400 mt-1">Minimum 8 characters.</p>
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="form-input" placeholder="Confirm new password">
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                        Update Password
                    </button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.app>
