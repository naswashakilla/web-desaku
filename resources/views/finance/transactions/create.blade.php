<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Transaksi - Desa Sejahtera</title>
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

<div class="max-w-2xl mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Catat Transaksi Kas</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl mb-6 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl border shadow-sm p-6">
        <form action="{{ route('finance.transactions.store') }}" method="POST">
            @csrf

            {{-- Jenis --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Transaksi</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center gap-2 border-2 rounded-lg px-4 py-3 cursor-pointer hover:border-green-400 transition
                        {{ old('type') == 'income' ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">
                        <input type="radio" name="type" value="income" class="text-green-600"
                               {{ old('type', 'income') == 'income' ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-green-700">⬆️ Pemasukan</span>
                    </label>
                    <label class="flex items-center gap-2 border-2 rounded-lg px-4 py-3 cursor-pointer hover:border-red-400 transition
                        {{ old('type') == 'expense' ? 'border-red-500 bg-red-50' : 'border-gray-200' }}">
                        <input type="radio" name="type" value="expense" class="text-red-500"
                               {{ old('type') == 'expense' ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-red-600">⬇️ Pengeluaran</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}"
                       placeholder="Contoh: Pembelian cat pagar RT"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="amount" value="{{ old('amount') }}"
                           placeholder="Contoh: 150000"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="category"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="iuran">Iuran Warga</option>
                    <option value="keamanan">Keamanan</option>
                    <option value="kebersihan">Kebersihan</option>
                    <option value="kegiatan">Kegiatan</option>
                    <option value="infrastruktur">Infrastruktur</option>
                    <option value="operasional">Operasional</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (opsional)</label>
                <textarea name="description" rows="3"
                          placeholder="Keterangan tambahan..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('description') }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-green-700 transition">
                    Simpan Transaksi
                </button>
                <a href="/keuangan"
                   class="border border-gray-300 text-gray-600 px-6 py-2 rounded-lg text-sm hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<footer class="bg-green-900 text-green-200 py-6 text-center text-sm mt-12">
    <p>© {{ date('Y') }} Desa Sejahtera</p>
</footer>
</body>
</html>