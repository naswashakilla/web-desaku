<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Desa Sejahtera</title>
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
        <div class="flex gap-4 text-sm items-center">
            <a href="/keuangan" class="text-gray-600 hover:text-green-700">← Kembali</a>
            @auth
                <a href="/admin/keuangan/transaksi/buat"
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">+ Catat</a>
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button class="text-red-500 hover:underline">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<div class="bg-green-700 text-white py-10 px-4 text-center">
    <h1 class="text-3xl font-bold mb-2">Riwayat Transaksi</h1>
    <p class="text-green-100">Catatan pemasukan dan pengeluaran kas RT</p>
</div>

<div class="max-w-4xl mx-auto py-10 px-4">

    {{-- Ringkasan --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl p-5 border shadow-sm text-center">
            <p class="text-sm text-gray-500 mb-1">Pemasukan</p>
            <p class="text-xl font-bold text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl p-5 border shadow-sm text-center">
            <p class="text-sm text-gray-500 mb-1">Pengeluaran</p>
            <p class="text-xl font-bold text-red-500">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl p-5 border shadow-sm text-center">
            <p class="text-sm text-gray-500 mb-1">Saldo</p>
            <p class="text-xl font-bold {{ $balance >= 0 ? 'text-green-700' : 'text-red-600' }}">
                Rp {{ number_format($balance, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Tabel Transaksi --}}
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        @forelse($transactions as $trx)
            <div class="flex items-center justify-between px-5 py-4 border-b last:border-0 hover:bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg
                        {{ $trx->isIncome() ? 'bg-green-100' : 'bg-red-100' }}">
                        {{ $trx->isIncome() ? '⬆️' : '⬇️' }}
                    </div>
                    <div>
                        <p class="font-medium text-sm text-gray-800">{{ $trx->title }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $trx->date->format('d M Y') }} ·
                            <span class="capitalize">{{ $trx->category }}</span> ·
                            {{ $trx->author->name }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="font-semibold {{ $trx->isIncome() ? 'text-green-600' : 'text-red-500' }}">
                        {{ $trx->isIncome() ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </span>
                    @auth
                        <form method="POST" action="{{ route('finance.transactions.destroy', $trx) }}"
                              onsubmit="return confirm('Yakin hapus transaksi ini?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-400 hover:text-red-600">✕</button>
                        </form>
                    @endauth
                </div>
            </div>
        @empty
            <div class="p-10 text-center text-gray-400">
                <p class="text-4xl mb-3">📊</p>
                <p>Belum ada transaksi dicatat.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $transactions->links() }}</div>
</div>

<footer class="bg-green-900 text-green-200 py-6 text-center text-sm mt-12">
    <p>© {{ date('Y') }} Desa Sejahtera</p>
</footer>
</body>
</html>