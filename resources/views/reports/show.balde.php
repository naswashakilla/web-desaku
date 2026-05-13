<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan #{{ $report->id }} - Desa Sejahtera</title>
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
            <a href="/laporan" class="text-gray-600 hover:text-green-700">← Kembali</a>
            @auth
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button class="text-red-500 hover:underline">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<div class="max-w-3xl mx-auto py-10 px-4">

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-xl mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Info Laporan --}}
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden mb-6">
        @if($report->photo)
            <img src="{{ Storage::url($report->photo) }}" class="w-full h-64 object-cover">
        @else
            <div class="w-full h-40 bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center text-5xl">🔔</div>
        @endif

        <div class="p-6">
            <div class="flex flex-wrap gap-2 mb-3">
                <span class="text-xs px-3 py-1 rounded-full font-medium
                    {{ $report->status == 'pending' ? 'bg-yellow-100 text-yellow-700' :
                      ($report->status == 'process' ? 'bg-blue-100 text-blue-700' :
                                                      'bg-green-100 text-green-700') }}">
                    {{ $report->status_label }}
                </span>
                <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                    {{ $report->category }}
                </span>
                <span class="text-xs text-gray-400 px-2 py-1">
                    Laporan #{{ $report->id }}
                </span>
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mb-3">{{ $report->title }}</h1>

            <div class="grid grid-cols-2 gap-3 text-sm text-gray-500 mb-4 pb-4 border-b">
                <span>📍 {{ $report->location }}</span>
                <span>👤 {{ $report->reporter_name }}</span>
                @if($report->reporter_phone)
                    <span>📞 {{ $report->reporter_phone }}</span>
                @endif
                <span>🕒 {{ $report->created_at->format('d M Y, H:i') }}</span>
            </div>

            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $report->description }}</p>
        </div>
    </div>

    {{-- Form Update Status (Admin) --}}
    @auth
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
            <h2 class="font-semibold text-blue-800 mb-4">⚙️ Update Status Laporan</h2>
            <form action="{{ route('reports.updateStatus', $report) }}" method="POST">
                @csrf
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Baru</label>
                        <select name="status"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                            <option value="process" {{ $report->status == 'process' ? 'selected' : '' }}>🔄 Diproses</option>
                            <option value="done"    {{ $report->status == 'done'    ? 'selected' : '' }}>✅ Selesai</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Catatan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="note"
                               placeholder="Contoh: Sudah dilaporkan ke dinas PU"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                    Simpan Update
                </button>
            </form>
        </div>
    @endauth

    {{-- Timeline Update --}}
    <div class="bg-white rounded-xl border shadow-sm p-6">
        <h2 class="font-semibold text-gray-800 mb-5">📋 Riwayat Penanganan</h2>
        <div class="space-y-4">
            @forelse($updates as $update)
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0
                            {{ $update->status == 'pending' ? 'bg-yellow-100 text-yellow-700' :
                              ($update->status == 'process' ? 'bg-blue-100 text-blue-700' :
                                                              'bg-green-100 text-green-700') }}">
                            {{ $update->status == 'pending' ? '⏳' : ($update->status == 'process' ? '🔄' : '✅') }}
                        </div>
                        @if(!$loop->last)
                            <div class="w-0.5 h-full bg-gray-200 mt-2"></div>
                        @endif
                    </div>
                    <div class="pb-4 flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full
                                {{ $update->status == 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                  ($update->status == 'process' ? 'bg-blue-100 text-blue-700' :
                                                                  'bg-green-100 text-green-700') }}">
                                {{ $update->status == 'pending' ? 'Diterima' :
                                  ($update->status == 'process' ? 'Diproses' : 'Selesai') }}
                            </span>
                            <span class="text-xs text-gray-400">
                                {{ $update->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-700">{{ $update->note }}</p>
                        @if($update->admin)
                            <p class="text-xs text-gray-400 mt-1">oleh {{ $update->admin->name }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-sm text-center py-4">Belum ada update.</p>
            @endforelse
        </div>
    </div>

</div>

<footer class="bg-green-900 text-green-200 py-6 text-center text-sm mt-12">
    <p>© {{ date('Y') }} Desa Sejahtera</p>
</footer>
</body>
</html>