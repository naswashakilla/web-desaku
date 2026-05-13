<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $due->name }} - Desa Sejahtera</title>
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
                <a href="/admin/keuangan/pembayaran/pending"
                   class="text-yellow-600 hover:underline">Pembayaran Pending</a>
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button class="text-red-500 hover:underline">Logout</button>
                </form>
            @else
                <a href="/login" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Login Admin</a>
            @endauth
        </div>
    </div>
</nav>

<div class="max-w-4xl mx-auto py-10 px-4">

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-xl mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl mb-6">
            ❌ {{ session('error') }}
        </div>
    @endif

    {{-- Info Iuran --}}
    <div class="bg-white rounded-xl border shadow-sm p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $due->name }}</h1>
                <p class="text-gray-400 text-sm mt-1">
                    {{ \Carbon\Carbon::parse($due->month.'-01')->format('F Y') }}
                </p>
                @if($due->description)
                    <p class="text-gray-600 text-sm mt-2">{{ $due->description }}</p>
                @endif
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-green-600">
                    Rp {{ number_format($due->amount, 0, ',', '.') }}
                </p>
                <p class="text-sm text-gray-400 mt-1">per warga</p>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4 mt-6 pt-4 border-t">
            <div class="text-center">
                <p class="text-2xl font-bold text-green-600">
                    {{ $payments->where('status','confirmed')->count() }}
                </p>
                <p class="text-xs text-gray-400">Sudah Bayar</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-yellow-500">
                    {{ $payments->where('status','pending')->count() }}
                </p>
                <p class="text-xs text-gray-400">Menunggu</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-gray-600">
                    Rp {{ number_format($due->totalCollected(), 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-400">Terkumpul</p>
            </div>
        </div>
    </div>

    {{-- Form Lapor Bayar (semua warga, tanpa login) --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
        <h2 class="font-semibold text-blue-800 mb-1">💳 Lapor Pembayaran Iuran</h2>
        <p class="text-sm text-blue-600 mb-4">Isi form di bawah setelah kamu melakukan pembayaran</p>

        <form action="{{ route('finance.dues.pay', $due) }}" method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="resident_name" value="{{ old('resident_name') }}"
                           placeholder="Contoh: Budi Santoso"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('resident_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                    <input type="text" name="resident_phone" value="{{ old('resident_phone') }}"
                           placeholder="Contoh: 08123456789"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat / No. Rumah</label>
                    <input type="text" name="address" value="{{ old('address') }}"
                           placeholder="Contoh: RT 04 No. 12"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Jumlah Dibayar (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="amount" value="{{ old('amount', $due->amount) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Bukti Transfer (opsional)
                    </label>
                    <input type="file" name="proof" accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <p class="text-xs text-gray-400 mt-1">Maks 2MB. Format JPG/PNG</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <input type="text" name="note" value="{{ old('note') }}"
                           placeholder="Contoh: Transfer via BCA"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                📤 Kirim Laporan Pembayaran
            </button>
        </form>
    </div>

    {{-- Daftar Pembayaran --}}
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b bg-gray-50 flex justify-between items-center">
            <h2 class="font-semibold text-gray-700">Daftar Pembayaran Masuk</h2>
            <span class="text-sm text-gray-400">
                {{ $payments->where('status','confirmed')->count() }} terkonfirmasi
            </span>
        </div>

        @forelse($payments as $payment)
            <div class="flex items-center justify-between px-5 py-4 border-b last:border-0 hover:bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center text-sm font-bold text-green-700">
                        {{ strtoupper(substr($payment->resident_name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-medium text-sm text-gray-800">{{ $payment->resident_name }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $payment->created_at->format('d M Y') }}
                            @if($payment->address) · {{ $payment->address }} @endif
                            @if($payment->note) · {{ $payment->note }} @endif
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 flex-wrap justify-end">
                    <span class="font-medium text-sm text-green-600">
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </span>

                    @if($payment->proof)
                        <a href="{{ Storage::url($payment->proof) }}" target="_blank"
                           class="text-xs text-blue-500 hover:underline">📎 Bukti</a>
                    @endif

                    <span class="text-xs px-2 py-1 rounded-full font-medium
                        {{ $payment->isConfirmed() ? 'bg-green-100 text-green-700' :
                          ($payment->isRejected()  ? 'bg-red-100 text-red-600' :
                                                     'bg-yellow-100 text-yellow-700') }}">
                        {{ $payment->isConfirmed() ? 'Terkonfirmasi' :
                          ($payment->isRejected()  ? 'Ditolak' : 'Pending') }}
                    </span>

                    @auth
                        @if($payment->isPending())
                            <form method="POST"
                                  action="{{ route('finance.payments.confirm', $payment) }}"
                                  class="inline">
                                @csrf
                                <button class="text-xs bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700">
                                    ✓
                                </button>
                            </form>
                            <form method="POST"
                                  action="{{ route('finance.payments.reject', $payment) }}"
                                  class="inline">
                                @csrf
                                <input type="hidden" name="admin_note" value="Ditolak admin">
                                <button class="text-xs bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                                    ✗
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-gray-400">
                <p class="text-3xl mb-2">📭</p>
                <p>Belum ada yang melapor pembayaran.</p>
            </div>
        @endforelse
    </div>

</div>

<footer class="bg-green-900 text-green-200 py-6 text-center text-sm mt-12">
    <p>© {{ date('Y') }} Desa Sejahtera</p>
</footer>

</body>
</html>