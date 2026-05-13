<?php
namespace App\Http\Controllers;

use App\Models\Due;
use App\Models\DuePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DuePaymentController extends Controller
{
    // Warga lapor bayar TANPA login
    public function store(Request $request, Due $due)
    {
        $request->validate([
            'resident_name'  => 'required|string|max:255',
            'resident_phone' => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:255',
            'amount'         => 'required|integer|min:0',
            'proof'          => 'nullable|image|max:2048',
            'note'           => 'nullable|string',
        ]);

        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('payments', 'public');
        }

        DuePayment::create([
            'due_id'         => $due->id,
            'resident_name'  => $request->resident_name,
            'resident_phone' => $request->resident_phone,
            'address'        => $request->address,
            'amount'         => $request->amount,
            'proof'          => $proofPath,
            'note'           => $request->note,
            'status'         => 'pending',
        ]);

        return back()->with('success', 'Laporan pembayaran berhasil dikirim! Admin akan segera mengkonfirmasi.');
    }

    // Admin konfirmasi
    public function confirm(DuePayment $payment)
    {
        $payment->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
        ]);
        return back()->with('success', 'Pembayaran dikonfirmasi!');
    }

    // Admin tolak
    public function reject(Request $request, DuePayment $payment)
    {
        $payment->update([
            'status'     => 'rejected',
            'admin_note' => $request->admin_note,
        ]);
        return back()->with('success', 'Pembayaran ditolak.');
    }

    // Daftar pending (admin)
    public function pending()
    {
        $payments = DuePayment::with('due')
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return view('finance.payments.pending', compact('payments'));
    }
}