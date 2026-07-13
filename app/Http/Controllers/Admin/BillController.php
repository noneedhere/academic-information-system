<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBillRequest;
use App\Http\Requests\Admin\UpdateBillRequest;
use App\Models\Bill;
use App\Models\Role;
use App\Models\User;
use App\Services\BillService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillController extends Controller
{
    public function __construct(
        private BillService $billService,
    ) {}

    /**
     * Display a listing of all bills with filters.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Bill::class);

        $query = Bill::with('student');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by student
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $bills = $query->latest('due_date')
            ->paginate(20)
            ->withQueryString();

        // Get students for filter dropdown
        $students = User::whereHas('role', fn ($q) => $q->where('slug', Role::STUDENT))
            ->orderBy('name')
            ->get();

        return view('admin.bills.index', compact('bills', 'students'));
    }

    /**
     * Show the form for creating a new bill.
     */
    public function create(): View
    {
        $this->authorize('create', Bill::class);

        $students = User::whereHas('role', fn ($q) => $q->where('slug', Role::STUDENT))
            ->orderBy('name')
            ->get();

        return view('admin.bills.create', compact('students'));
    }

    /**
     * Store a newly created bill.
     */
    public function store(StoreBillRequest $request): RedirectResponse
    {
        $this->authorize('create', Bill::class);

        Bill::create($request->validated());

        return redirect()->route('admin.bills.index')
            ->with('success', 'Bill created successfully.');
    }

    /**
     * Show the form for editing the specified bill.
     */
    public function edit(Bill $bill): View
    {
        $this->authorize('update', $bill);

        $students = User::whereHas('role', fn ($q) => $q->where('slug', Role::STUDENT))
            ->orderBy('name')
            ->get();

        return view('admin.bills.edit', compact('bill', 'students'));
    }

    /**
     * Update the specified bill.
     */
    public function update(UpdateBillRequest $request, Bill $bill): RedirectResponse
    {
        $this->authorize('update', $bill);

        $bill->update($request->validated());

        return redirect()->route('admin.bills.index')
            ->with('success', 'Bill updated successfully.');
    }

    /**
     * Remove the specified bill (soft delete).
     */
    public function destroy(Bill $bill): RedirectResponse
    {
        $this->authorize('delete', $bill);

        $bill->delete();

        return redirect()->route('admin.bills.index')
            ->with('success', 'Bill deleted successfully.');
    }

    /**
     * Toggle the bill's payment status between paid and unpaid.
     */
    public function toggleStatus(Bill $bill): RedirectResponse
    {
        $this->authorize('toggleStatus', $bill);

        $this->billService->toggleStatus($bill);

        $newStatus = $bill->fresh()->status->label();

        return back()->with('success', "Bill status changed to {$newStatus}.");
    }
}
