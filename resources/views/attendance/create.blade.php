<x-layouts.app :title="'Record Attendance'">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="page-title">Record Attendance</h1>
                <p class="page-subtitle">Submit attendance for all students</p>
            </div>
            <a href="{{ route('attendance.index') }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
                Back to Records
            </a>
        </div>
    </div>

    @if ($students->isEmpty())
        <x-card>
            <div class="text-center py-12">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                <p class="text-gray-500 font-medium">No students found</p>
                <p class="text-sm text-gray-400 mt-1">There are no students registered in the system.</p>
            </div>
        </x-card>
    @else
        <form method="POST" action="{{ route('attendance.store') }}" data-loading>
            @csrf

            {{-- Date Selector --}}
            <x-card class="mb-6">
                <div class="max-w-xs">
                    <div class="form-group">
                        <label for="date" class="form-label">Attendance Date</label>
                        <input id="date" type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                               class="form-input" max="{{ date('Y-m-d') }}">
                        @error('date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-card>

            {{-- Student Attendance Table --}}
            <x-card :padding="false" title="Student List" subtitle="Set attendance status for each student">
                @error('attendances')
                    <div class="px-5 pb-0">
                        <p class="form-error">{{ $message }}</p>
                    </div>
                @enderror

                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="w-12">#</th>
                                <th>Student</th>
                                <th class="w-44">Status</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $index => $student)
                                <tr>
                                    <td class="text-gray-400 font-mono text-xs">{{ $index + 1 }}</td>
                                    <td>
                                        <input type="hidden" name="attendances[{{ $index }}][student_id]" value="{{ $student->id }}">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $student->profile_photo_url }}" alt="{{ $student->name }}"
                                                 class="w-8 h-8 rounded-full object-cover">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $student->name }}</p>
                                                <p class="text-xs text-gray-400">{{ $student->username }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <select name="attendances[{{ $index }}][status]" required class="form-select text-sm">
                                            @foreach (App\Enums\AttendanceStatus::cases() as $status)
                                                <option value="{{ $status->value }}"
                                                    {{ old("attendances.{$index}.status", 'present') === $status->value ? 'selected' : '' }}>
                                                    {{ $status->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error("attendances.{$index}.status")
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" name="attendances[{{ $index }}][notes]"
                                               value="{{ old("attendances.{$index}.notes") }}"
                                               class="form-input text-sm" placeholder="Optional notes...">
                                        @error("attendances.{$index}.notes")
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>

            {{-- Submit --}}
            <div class="mt-6 flex items-center gap-3">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                    Save Attendance
                </button>
                <a href="{{ route('attendance.index') }}" class="btn-ghost">Cancel</a>
            </div>
        </form>
    @endif
</x-layouts.app>
