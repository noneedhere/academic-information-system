<x-layouts.app :title="'Edit Bill'">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="page-title">Edit Bill</h1>
                <p class="page-subtitle">Update bill: {{ $bill->title }}</p>
            </div>
            <a href="{{ route('admin.bills.index') }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
                Back to Bills
            </a>
        </div>
    </div>

    <div class="max-w-3xl">
        <x-card title="Bill Information" subtitle="Update the bill details">
            <form method="POST" action="{{ route('admin.bills.update', $bill) }}" data-loading class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Student --}}
                <div class="form-group">
                    <label for="student_id" class="form-label">Student</label>
                    <select id="student_id" name="student_id" required class="form-select">
                        <option value="">Select a student</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id', $bill->student_id) == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} ({{ $student->username }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Title --}}
                <div class="form-group">
                    <label for="title" class="form-label">Title</label>
                    <input id="title" type="text" name="title" value="{{ old('title', $bill->title) }}" required
                           class="form-input" placeholder="e.g. Tuition Fee - Semester 1">
                    @error('title')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label for="description" class="form-label">Description <span class="text-gray-400 font-normal">(optional)</span></label>
                    <textarea id="description" name="description" rows="3"
                              class="form-input" placeholder="Additional details about this bill">{{ old('description', $bill->description) }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Amount & Due Date --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="amount" class="form-label">Amount (Rp)</label>
                        <input id="amount" type="number" name="amount" value="{{ old('amount', $bill->amount) }}" required
                               class="form-input" placeholder="0" min="0" step="0.01">
                        @error('amount')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input id="due_date" type="date" name="due_date" value="{{ old('due_date', $bill->due_date->format('Y-m-d')) }}" required
                               class="form-input">
                        @error('due_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        @foreach (App\Enums\BillStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ old('status', $bill->status->value) === $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        Update Bill
                    </button>
                    <a href="{{ route('admin.bills.index') }}" class="btn-ghost">Cancel</a>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.app>
