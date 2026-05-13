<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('author')->latest()->paginate(15);
        $totalIncome  = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        $balance      = $totalIncome - $totalExpense;

        return view('finance.transactions.index', compact(
            'transactions', 'totalIncome', 'totalExpense', 'balance'
        ));
    }

    public function create()
    {
        return view('finance.transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'     => 'required|in:income,expense',
            'title'    => 'required|max:255',
            'amount'   => 'required|integer|min:0',
            'category' => 'required',
            'date'     => 'required|date',
        ]);

        Transaction::create([
            'type'        => $request->type,
            'title'       => $request->title,
            'amount'      => $request->amount,
            'category'    => $request->category,
            'description' => $request->description,
            'date'        => $request->date,
            'user_id'     => auth()->id(),
        ]);

        return redirect()->route('finance.transactions.index')
            ->with('success', 'Transaksi berhasil dicatat!');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return back()->with('success', 'Transaksi berhasil dihapus!');
    }
}