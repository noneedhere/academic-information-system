<x-layouts.app :title="'My Bills'">
    {{-- Page Header --}}
    <div class="page-header">
        <h1 class="page-title">My Bills</h1>
        <p class="page-subtitle">View your payment status and history</p>
    </div>

    {{-- Summary Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="stat-card">
            <div class="stat-icon bg-primary-50 text-primary-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Bills</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalBills }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-amber-50 text-amber-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Unpaid Amount</p>
                <p class="text-2xl font-bold text-amber-600">Rp {{ number_format($unpaidAmount, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-emerald-50 text-emerald-600">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Paid Amount</p>
                <p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($paidAmount, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <x-card class="mb-6">
        <form method="GET" action="{{ route('bills.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach (App\Enums\BillStatus::cases() as $status)
                        <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="search" class="form-label">Search</label>
                <input id="search" type="text" name="search" value="{{ request('search') }}"
                       class="form-input" placeholder="Search by title...">
            </div>
            <div class="form-group flex items-end gap-2">
                <button type="submit" class="btn-primary flex-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    Filter
                </button>
                @if (request()->hasAny(['status', 'search']))
                    <a href="{{ route('bills.index') }}" class="btn-ghost">Clear</a>
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
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bills as $bill)
                        <tr>
                            <td>
                                <p class="font-medium text-gray-900">{{ $bill->title }}</p>
                            </td>
                            <td class="text-sm text-gray-500 max-w-xs truncate">{{ $bill->description ?? '—' }}</td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                </svg>
                                <p class="text-gray-500 font-medium">No bills found</p>
                                <p class="text-sm text-gray-400 mt-1">You don't have any bills yet.</p>
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
