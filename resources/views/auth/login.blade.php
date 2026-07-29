<x-layouts.guest :title="'Login'">
    <div class="space-y-6">
        <div class="text-center">
            <h2 class="text-xl font-bold text-gray-900">Welcome back</h2>
            <p class="text-sm text-gray-500 mt-1">Sign in to your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}" data-loading class="space-y-5">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="form-input" placeholder="you@example.com">
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required class="form-input"
                    placeholder="••••••••">
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember me --}}
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <span class="text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-primary w-full">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                </svg>
                Sign In
            </button>
        </form>

        {{-- Register link
        <p class="text-center text-sm text-gray-500">
            Don't have an account?
            <a href="{{ route('register') }}"
                class="font-semibold text-primary-600 hover:text-primary-500 transition-colors">
                Register here
            </a>
        </p> --}}
    </div>
</x-layouts.guest>
