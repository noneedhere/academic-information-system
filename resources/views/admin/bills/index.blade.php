<x-layouts.app :title="'Bill Management'">
    {{-- Page Header --}}
    <div class="page-header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="page-title">Bill Management</h1>
                <p class="page-subtitle">Manage student bills and payments</p>
            </div>
            <a href="{{ route('admin.bills.create') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Create Bill
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <x-card class="mb-6">
        <form method="GET" action="{{ route('admin.bills.index') }}"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach (App\Enums\BillStatus::cases() as $status)
                        <option value="{{ $status->value }}"
                            {{ request('status') === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="student_id" class="form-label">Student</label>
                <select id="student_id" name="student_id" class="form-select">
                    <option value="">All Students</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}"
                            {{ request('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="search" class="form-label">Search</label>
                <input id="search" type="text" name="search" value="{{ request('search') }}" class="form-input"
                    placeholder="Search by title...">
            </div>
            <div class="form-group flex items-end gap-2">
                <button type="submit" class="btn-primary flex-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    Filter
                </button>
                @if (request()->hasAny(['status', 'student_id', 'search']))
                    <a href="{{ route('admin.bills.index') }}" class="btn-ghost">Clear</a>
                @endif
            </div>
        </form>
    </x-card>

    {{-- Table --}}
    <x-card :padding="false">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Student</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bills as $bill)
                        <tr>
                            <td>
                                <p class="font-medium text-gray-900">{{ $bill->title }}</p>
                                @if ($bill->description)
                                    <p class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">{{ $bill->description }}
                                    </p>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <img src="{{ $bill->student->profile_photo_url }}"
                                        alt="{{ $bill->student->name }}" class="w-7 h-7 rounded-full object-cover">
                                    <span class="text-sm text-gray-700">{{ $bill->student->name }}</span>
                                </div>
                            </td>
                            <td class="font-semibold text-gray-900">{{ $bill->formattedAmount() }}</td>
                            <td>
                                <div>
                                    <p class="text-sm">{{ $bill->due_date->format('d M Y') }}</p>
                                    @if ($bill->is_overdue)
                                        <p class="text-xs text-red-500 font-medium mt-0.5">Overdue</p>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge-{{ $bill->status->color() }}">
                                    {{ $bill->status->label() }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Toggle Status --}}
                                    <form method="POST" action="{{ route('admin.bills.toggle-status', $bill) }}"
                                        class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="btn-ghost btn-sm {{ $bill->status === App\Enums\BillStatus::Paid ? 'text-amber-600 hover:bg-amber-50' : 'text-emerald-600 hover:bg-emerald-50' }}"
                                            title="Mark as {{ $bill->status === App\Enums\BillStatus::Paid ? 'Unpaid' : 'Paid' }}">
                                            @if ($bill->status === App\Enums\BillStatus::Paid)
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18 18 6M6 6l12 12" />
                                                </svg>
                                                Unpaid
                                            @else
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m4.5 12.75 6 6 9-13.5" />
                                                </svg>
                                                Paid
                                            @endif
                                        </button>
                                    </form>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.bills.edit', $bill) }}" class="btn-ghost btn-sm"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                        Edit
                                    </a>

                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('admin.bills.destroy', $bill) }}"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn-ghost btn-sm text-red-600 hover:text-red-700 hover:bg-red-50"
                                            data-confirm="Are you sure you want to delete this bill? This action cannot be undone.">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <p class="text-gray-500 font-medium">No bills found</p>
                                <p class="text-sm text-gray-400 mt-1">Try adjusting your filters or create a new bill.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    {{-- Pagination --}}
    @if ($bills->hasPages())
        <div class="pagination-wrapper mt-6">
            {{ $bills->links() }}
        </div>
    @endif
</x-layouts.app>
