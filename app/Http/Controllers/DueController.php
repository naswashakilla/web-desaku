<?php
namespace App\Http\Controllers;

use App\Models\Due;
use App\Models\DuePayment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DueController extends Controller
{
    public function index()
    {
        $dues = Due::latest()->paginate(10);

        $totalIncome  = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        $balance      = $totalIncome - $totalExpense;

        $recentTransactions = Transaction::with('author')->latest()->take(5)->get();
        $pendingPayments    = DuePayment::where('status', 'pending')->count();

        return view('finance.index', compact(
            'dues', 'totalIncome', 'totalExpense',
            'balance', 'recentTransactions', 'pendingPayments'
        ));
    }

    public function create()
    {
        return view('finance.dues.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|max:255',
            'amount' => 'required|integer|min:0',
            'month'  => 'required',
        ]);

        Due::create($request->only('name', 'amount', 'month', 'description'));

        return redirect()->route('finance.index')
            ->with('success', 'Iuran berhasil dibuat!');
    }

    // ← Ini yang diubah
    public function show(Due $due)
    {
        $payments = $due->payments()->latest()->get();

        return view('finance.dues.show', compact('due', 'payments'));
    }

    public function destroy(Due $due)
    {
        $due->delete();
        return redirect()->route('finance.index')
            ->with('success', 'Iuran berhasil dihapus!');
    }
}