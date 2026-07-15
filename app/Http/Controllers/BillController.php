<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BillController extends Controller
{
    /**
     * Display the student's own bills.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Bill::class);

        $user = Auth::user();

        $query = Bill::where('student_id', $user->id);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by search (title)
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $bills = $query->latest('due_date')
            ->paginate(15)
            ->withQueryString();

        // Summary stats
        $totalBills   = Bill::where('student_id', $user->id)->count();
        $unpaidAmount = Bill::where('student_id', $user->id)
            ->where('status', 'unpaid')
            ->sum('amount');
        $paidAmount   = Bill::where('student_id', $user->id)
            ->where('status', 'paid')
            ->sum('amount');

        return view('bills.index', compact('bills', 'totalBills', 'unpaidAmount', 'paidAmount'));
    }
}
