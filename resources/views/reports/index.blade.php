<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Masalah - Desa Sejahtera</title>
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
            <a href="/keuangan" class="text-gray-600 hover:text-green-700">Keuangan</a>
            <a href="/laporan" class="text-green-700 border-b-2 border-green-600 pb-1">Laporan</a>
        </div>
        <div class="flex gap-3 items-center">
            @auth
                <a href="/admin/laporan" class="border border-gray-300 text-gray-600 text-sm px-4 py-2 rounded-lg hover:bg-gray-50">Kelola Laporan</a>
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
    <h1 class="text-3xl font-bold mb-2">Laporan Masalah Lingkungan</h1>
    <p class="text-green-100 mb-6">Laporkan masalah di sekitar lingkunganmu, kami akan segera menindaklanjuti</p>
    <a href="/laporan/buat"
       class="bg-white text-green-700 font-semibold px-6 py-3 rounded-lg hover:bg-green-50 transition">
        + Buat Laporan Baru
    </a>
</div>

<div class="max-w-5xl mx-auto py-10 px-4">

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-xl mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Statistik --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl p-5 border shadow-sm text-center">
            <p class="text-2xl font-bold text-yellow-500">{{ $totalPending }}</p>
            <p class="text-sm text-gray-500 mt-1">Menunggu</p>
        </div>
        <div class="bg-white rounded-xl p-5 border shadow-sm text-center">
            <p class="text-2xl font-bold text-blue-500">{{ $totalProcess }}</p>
            <p class="text-sm text-gray-500 mt-1">Diproses</p>
        </div>
        <div class="bg-white rounded-xl p-5 border shadow-sm text-center">
            <p class="text-2xl font-bold text-green-600">{{ $totalDone }}</p>
            <p class="text-sm text-gray-500 mt-1">Selesai</p>
        </div>
    </div>

    {{-- Daftar Laporan --}}
    <div class="space-y-4">
        @forelse($reports as $report)
            <div class="bg-white rounded-xl border shadow-sm hover:shadow-md transition overflow-hidden">
                <div class="flex gap-4 p-5">
                    @if($report->photo)
                        <img src="{{ Storage::url($report->photo) }}"
                             class="w-28 h-24 object-cover rounded-lg flex-shrink-0">
                    @else
                        <div class="w-28 h-24 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg flex items-center justify-center text-3xl flex-shrink-0">
                            🔔
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-2 flex-wrap">
                            <span class="text-xs px-2 py-1 rounded-full font-medium
                                {{ $report->status == 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                  ($report->status == 'process' ? 'bg-blue-100 text-blue-700' :
                                                                  'bg-green-100 text-green-700') }}">
                                {{ $report->status_label }}
                            </span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                {{ $report->category }}
                            </span>
                            <span class="text-xs text-gray-400">
                                #{{ $report->id }} · {{ $report->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <h2 class="text-base font-semibold text-gray-800">{{ $report->title }}</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            📍 {{ $report->location }} · 👤 {{ $report->reporter_name }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($report->description, 100) }}</p>
                        <a href="{{ route('reports.show', $report) }}"
                           class="text-green-600 text-sm mt-2 inline-block hover:underline">
                            Lihat detail →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border p-12 text-center">
                <div class="text-5xl mb-3">📭</div>
                <p class="text-gray-500 font-medium">Belum ada laporan masalah.</p>
                <a href="/laporan/buat"
                   class="inline-block mt-4 bg-green-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-green-700">
                    + Buat Laporan Pertama
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $reports->links() }}</div>
</div>

<footer class="bg-green-900 text-green-200 py-6 text-center text-sm mt-12">
    <p>© {{ date('Y') }} Desa Sejahtera · Semua hak dilindungi</p>
</footer>
</body>
</html>