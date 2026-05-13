<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuangan Desa - Desa Sejahtera</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg">D</div>
            <div>
                <p class="font-bold text-green-800 leading-tight">Desa Sejahtera</p>
                <p class="text-xs text-gray-400">Portal Informasi Warga</p>
            </div>
        </a>
        <div class="hidden md:flex gap-6 text-sm font-medium">
            <a href="/" class="text-gray-600 hover:text-green-700">Beranda</a>
            <a href="/pengumuman" class="text-gray-600 hover:text-green-700">Pengumuman</a>
            <a href="/keuangan" class="text-green-700 border-b-2 border-green-600 pb-1">Keuangan</a>
        </div>
        <div class="flex gap-3 items-center">
            @auth
                <a href="/dashboard" class="border border-gray-300 text-gray-600 text-sm px-4 py-2 rounded-lg hover:bg-gray-50">Dashboard</a>
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button class="text-red-500 text-sm hover:underline">Logout</button>
                </form>
            @else
                <a href="/login" class="bg-green-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-green-700">Login</a>
            @endauth
        </div>
    </div>
</nav>

{{-- Header --}}
<div class="bg-green-700 text-white py-12 px-4 text-center">
    <h1 class="text-3xl font-bold mb-2">Keuangan Desa</h1>
    <p class="text-green-100">Transparansi kas dan iuran warga secara digital</p>
</div>

<div class="max-w-6xl mx-auto py-10 px-4">

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-xl mb-6 flex items-center gap-2">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Kartu Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <p class="text-sm text-gray-500 mb-1">Total Pemasukan</p>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-1">Dari iuran & sumber lain</p>
        </div>
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <p class="text-sm text-gray-500 mb-1">Total Pengeluaran</p>
            <p class="text-2xl font-bold text-red-500">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-1">Operasional & kegiatan</p>
        </div>
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <p class="text-sm text-gray-500 mb-1">Saldo Kas</p>
            <p class="text-2xl font-bold {{ $balance >= 0 ? 'text-green-700' : 'text-red-600' }}">
                Rp {{ number_format($balance, 0, ',', '.') }}
            </p>
            <p class="text-xs text-gray-400 mt-1">Per hari ini</p>
        </div>
    </div>

    {{-- Menu Admin --}}
    @auth
        <div class="flex flex-wrap gap-3 mb-8">
            <a href="/admin/keuangan/iuran/buat"
               class="bg-green-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-green-700 transition">
                + Buat Iuran Baru
            </a>
            <a href="/admin/keuangan/transaksi/buat"
               class="bg-blue-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                + Catat Transaksi
            </a>
            <a href="/admin/keuangan/pembayaran/pending"
               class="relative bg-yellow-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                ⏳ Pembayaran Pending
                @if($pendingPayments > 0)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                        {{ $pendingPayments }}
                    </span>
                @endif
            </a>
            <a href="/keuangan/transaksi"
               class="border border-gray-300 text-gray-600 text-sm px-4 py-2 rounded-lg hover:bg-gray-50 transition">
                Riwayat Transaksi
            </a>
        </div>
    @endauth

    {{-- Daftar Iuran --}}
    <div class="mb-10">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Daftar Iuran</h2>
        <div class="grid md:grid-cols-2 gap-4">
            @forelse($dues as $due)
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $due->name }}</h3>
                            <p class="text-sm text-gray-400 mt-1">{{ \Carbon\Carbon::parse($due->month.'-01')->translatedFormat('F Y') }}</p>
                        </div>
                        <span class="text-lg font-bold text-green-600">
                            Rp {{ number_format($due->amount, 0, ',', '.') }}
                        </span>
                    </div>
                    @if($due->description)
                        <p class="text-sm text-gray-500 mb-3">{{ $due->description }}</p>
                    @endif
                    <div class="flex items-center justify-between pt-3 border-t">
                        <span class="text-xs text-gray-400">
                            Terkumpul: <span class="text-green-600 font-medium">Rp {{ number_format($due->totalCollected(), 0, ',', '.') }}</span>
                        </span>
                        <div class="flex gap-2">
                            <a href="{{ route('finance.dues.show', $due) }}"
                               class="text-sm text-green-600 border border-green-300 px-3 py-1 rounded-lg hover:bg-green-50 transition">
                                Detail
                            </a>
                            @auth
                                <form method="POST" action="{{ route('finance.dues.destroy', $due) }}"
                                      onsubmit="return confirm('Yakin hapus iuran ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-sm text-red-500 border border-red-300 px-3 py-1 rounded-lg hover:bg-red-50 transition">
                                        Hapus
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 bg-white rounded-xl border p-10 text-center">
                    <div class="text-5xl mb-3">💰</div>
                    <p class="text-gray-500">Belum ada iuran yang dibuat.</p>
                    @auth
                        <a href="/admin/keuangan/iuran/buat"
                           class="inline-block mt-3 bg-green-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-green-700">
                            + Buat Iuran Pertama
                        </a>
                    @endauth
                </div>
            @endforelse
        </div>
        <div class="mt-4">{{ $dues->links() }}</div>
    </div>

    {{-- Transaksi Terbaru --}}
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Transaksi Terbaru</h2>
            <a href="/keuangan/transaksi" class="text-green-600 text-sm hover:underline">Lihat semua →</a>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            @forelse($recentTransactions as $trx)
                <div class="flex items-center justify-between px-5 py-4 border-b last:border-0 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg
                            {{ $trx->isIncome() ? 'bg-green-100' : 'bg-red-100' }}">
                            {{ $trx->isIncome() ? '⬆️' : '⬇️' }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $trx->title }}</p>
                            <p class="text-xs text-gray-400">{{ $trx->date->format('d M Y') }} · {{ $trx->category }}</p>
                        </div>
                    </div>
                    <span class="font-semibold {{ $trx->isIncome() ? 'text-green-600' : 'text-red-500' }}">
                        {{ $trx->isIncome() ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </span>
                </div>
            @empty
                <div class="p-8 text-center text-gray-400">
                    <p>Belum ada transaksi.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

<footer class="bg-green-900 text-green-200 py-6 text-center text-sm mt-12">
    <p>© {{ date('Y') }} Desa Sejahtera · Semua hak dilindungi</p>
</footer>

</body>
</html>