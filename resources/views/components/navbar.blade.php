{{-- Top Navbar --}}
<header class="sticky top-0 z-20 bg-white/80 backdrop-blur-md border-b border-gray-200/80">
    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
        {{-- Left: Mobile menu + Page info --}}
        <div class="flex items-center gap-3">
            {{-- Mobile hamburger --}}
            <button id="sidebar-open" class="lg:hidden p-2 -ml-2 rounded-lg hover:bg-gray-100 transition-colors text-gray-500">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            {{-- Breadcrumb / Page title --}}
            <div>
                <h2 class="text-lg font-semibold text-gray-900">{{ $title ?? '' }}</h2>
            </div>
        </div>

        {{-- Right: Clock + User --}}
        <div class="flex items-center gap-4">
            {{-- Real-time clock --}}
            <div class="hidden sm:flex items-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span id="realtime-clock" class="font-mono tabular-nums">--:--:--</span>
            </div>

            {{-- User dropdown --}}
            <div class="flex items-center gap-3">
                <div class="hidden sm:block text-right">
                    <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400">{{ Auth::user()->role->name }}</p>
                </div>
                <a href="{{ route('profile.show') }}">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"
                         class="w-9 h-9 rounded-full object-cover ring-2 ring-gray-200 hover:ring-primary-300 transition-all">
                </a>
            </div>
        </div>
    </div>
</header>
