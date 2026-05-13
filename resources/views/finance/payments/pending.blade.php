<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pending - Desa Sejahtera</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold">D</div>
            <div>
                <p class="font-bold text-green-800 leading-tight">Desa Sejahtera</p>
                <p class="text-xs text-gray-400">Portal Informasi Warga</p>
            </div>
        </a>
        <div class="flex gap-3 text-sm items-center">
            <a href="/keuangan" class="text-gray-600 hover:text-green-700">← Kembali</a>
            <form method="POST" action="/logout" class="inline">
                @csrf
                <button class="text-red-500 hover:underline">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="bg-yellow-500 text-white py-10 px-4 text-center">
    <h1 class="text-3xl font-bold mb-2">⏳ Pembayaran Pending</h1>
    <p class="text-yellow-100">Konfirmasi pembayaran iuran dari warga</p>
</div>

<div class="max-w-4xl mx-auto py-10 px-4">

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-xl mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        @forelse($payments as $payment)
            <div class="p-5 border-b last:border-0">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $payment->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $payment->due->name }}</p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $payment->created_at->format('d M Y, H:i') }}
                            @if($payment->note) · {{ $payment->note }} @endif
                        </p>
                    </div>
                    <p class="text-lg font-bold text-green-600">
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </p>
                </div>

                @if($payment->proof)
                    <a href="{{ Storage::url($payment->proof) }}" target="_blank"
                       class="inline-block mt-2 text-sm text-blue-500 hover:underline">
                        📎 Lihat Bukti Transfer
                    </a>
                @endif

                <div class="flex gap-3 mt-4">
                    <form method="POST" action="{{ route('finance.payments.confirm', $payment) }}">
                        @csrf
                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition">
                            ✓ Konfirmasi
                        </button>
                    </form>
                    <form method="POST" action="{{ route('finance.payments.reject', $payment) }}">
                        @csrf
                        <input type="text" name="admin_note" placeholder="Alasan penolakan..."
                               class="border border-gray-300 rounded-lg px-3 py-2 text-sm mr-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                        <button class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-600 transition">
                            ✗ Tolak
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-12 text-center text-gray-400">
                <p class="text-5xl mb-3">🎉</p>
                <p class="font-medium">Tidak ada pembayaran yang perlu dikonfirmasi!</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $payments->links() }}</div>
</div>

<footer class="bg-green-900 text-green-200 py-6 text-center text-sm mt-12">
    <p>© {{ date('Y') }} Desa Sejahtera</p>
</footer>
</body>
</html>