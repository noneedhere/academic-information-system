{{-- Reusable Modal Component --}}
@props([
    'id',
    'title' => 'Confirm',
    'maxWidth' => 'max-w-lg',
])

<div id="{{ $id }}" class="modal-overlay hidden" role="dialog" aria-modal="true" aria-labelledby="{{ $id }}-title">
    <div class="modal-panel {{ $maxWidth }}">
        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 id="{{ $id }}-title" class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
            <button type="button" data-modal-close class="p-1.5 rounded-lg hover:bg-gray-100 transition-colors text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 py-4">
            {{ $slot }}
        </div>

        {{-- Footer / Actions --}}
        @if (isset($actions))
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>
