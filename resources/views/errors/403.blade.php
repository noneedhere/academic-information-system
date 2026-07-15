<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — Forbidden</title>
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans">
    <div class="guest-bg">
        {{-- Decorative shapes --}}
        <div class="fixed inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
            <div class="absolute -top-20 -left-20 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute top-1/3 -right-20 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 w-full max-w-md mx-4 text-center animate-slide-in-up">
            {{-- Icon --}}
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-red-500/20 backdrop-blur-sm mb-6 ring-1 ring-red-400/30">
                <svg class="w-10 h-10 text-red-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>

            {{-- Error info --}}
            <h1 class="text-6xl font-bold text-white mb-2">403</h1>
            <h2 class="text-xl font-semibold text-white/80 mb-4">Access Forbidden</h2>
            <p class="text-white/50 mb-8">{{ $exception->getMessage() ?: 'You do not have permission to access this page.' }}</p>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ url()->previous() }}" class="btn bg-white/10 text-white hover:bg-white/20 ring-1 ring-white/20 backdrop-blur-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                    Go Back
                </a>
                <a href="{{ route('dashboard') }}" class="btn bg-white text-gray-900 hover:bg-gray-100 shadow-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Dashboard
                </a>
            </div>

            {{-- Footer --}}
            <p class="text-xs text-white/30 mt-10">&copy; {{ date('Y') }} {{ config('app.name', 'SIAKAD') }}</p>
        </div>
    </div>
</body>
</html>
