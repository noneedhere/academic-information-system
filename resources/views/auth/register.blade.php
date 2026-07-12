<x-layouts.guest :title="'Register'">
    <div class="space-y-6">
        <div class="text-center">
            <h2 class="text-xl font-bold text-gray-900">Create an account</h2>
            <p class="text-sm text-gray-500 mt-1">Register as a new student</p>
        </div>

        <form method="POST" action="{{ route('register') }}" data-loading class="space-y-5">
            @csrf

            {{-- Name --}}
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="form-input" placeholder="Your full name">
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Username --}}
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" required
                       class="form-input" placeholder="Choose a username">
                @error('username')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="form-input" placeholder="you@example.com">
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required
                       class="form-input" placeholder="Min. 8 characters">
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="form-input" placeholder="Repeat your password">
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-primary w-full">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
                Create Account
            </button>
        </form>

        {{-- Login link --}}
        <p class="text-center text-sm text-gray-500">
            Already have an account?
            <a href="{{ route('login') }}" class="font-semibold text-primary-600 hover:text-primary-500 transition-colors">
                Sign in
            </a>
        </p>
    </div>
</x-layouts.guest>
