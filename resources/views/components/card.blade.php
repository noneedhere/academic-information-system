{{-- Reusable Card Component --}}
@props([
    'title' => null,
    'subtitle' => null,
    'padding' => true,
    'gradient' => false,
    'headerActions' => null,
])

<div class="{{ $gradient ? 'card-gradient' : 'card' }}">
    @if ($title || $headerActions)
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div>
                @if ($title)
                    <h3 class="text-base font-semibold text-gray-900">{{ $title }}</h3>
                @endif
                @if ($subtitle)
                    <p class="text-sm text-gray-500 mt-0.5">{{ $subtitle }}</p>
                @endif
            </div>
            @if ($headerActions)
                <div class="flex items-center gap-2">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $padding ? 'p-5' : '' }}">
        {{ $slot }}
    </div>
</div>
