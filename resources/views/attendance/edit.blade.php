<x-layouts.app :title="'Edit Attendance'">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="page-title">Edit Attendance</h1>
                <p class="page-subtitle">Correct attendance for {{ $attendance->student->name }} on {{ $attendance->date->format('d M Y') }}</p>
            </div>
            <a href="{{ route('attendance.index') }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
                Back to Attendance
            </a>
        </div>
    </div>

    <div class="max-w-3xl">
        <x-card title="Attendance Details" subtitle="Update the status or notes for this record">
            <form method="POST" action="{{ route('attendance.update', $attendance) }}" data-loading class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Student (read-only) --}}
                <div class="form-group">
                    <label class="form-label">Student</label>
                    <div class="flex items-center gap-3 py-2">
                        <img src="{{ $attendance->student->profile_photo_url }}" alt="{{ $attendance->student->name }}"
                             class="w-9 h-9 rounded-full object-cover">
                        <div>
                            <p class="font-medium text-gray-900">{{ $attendance->student->name }}</p>
                            <p class="text-xs text-gray-400">{{ $attendance->student->username }}</p>
                        </div>
                    </div>
                </div>

                {{-- Date (read-only) --}}
                <div class="form-group">
                    <label class="form-label">Date</label>
                    <p class="py-2 text-gray-900">{{ $attendance->date->format('l, d F Y') }}</p>
                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" required class="form-select">
                        @foreach (App\Enums\AttendanceStatus::cases() as $status)
                            <option value="{{ $status->value }}"
                                {{ old('status', $attendance->status->value) === $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Notes --}}
                <div class="form-group">
                    <label for="notes" class="form-label">Notes <span class="text-gray-400 font-normal">(optional)</span></label>
                    <textarea id="notes" name="notes" rows="3"
                              class="form-input" placeholder="Reason for change or additional notes">{{ old('notes', $attendance->notes) }}</textarea>
                    @error('notes')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        Update Attendance
                    </button>
                    <a href="{{ route('attendance.index') }}" class="btn-ghost">Cancel</a>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.app>
