<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Laporan - Desa Sejahtera</title>
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
            <a href="/laporan" class="text-gray-600 hover:text-green-700">Lihat Publik</a>
            <a href="/dashboard" class="text-gray-600 hover:text-green-700">Dashboard</a>
            <form method="POST" action="/logout" class="inline">
                @csrf
                <button class="text-red-500 hover:underline">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="bg-orange-500 text-white py-10 px-4 text-center">
    <h1 class="text-3xl font-bold mb-2">⚙️ Kelola Laporan</h1>
    <p class="text-orange-100">Tindaklanjuti laporan masalah dari warga</p>
</div>

<div class="max-w-5xl mx-auto py-10 px-4">

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-xl mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        @forelse($reports as $report)
            <div class="flex items-center justify-between px-5 py-4 border-b last:border-0 hover:bg-gray-50">
                <div class="flex items-center gap-4">
                    @if($report->photo)
                        <img src="{{ Storage::url($report->photo) }}"
                             class="w-14 h-14 object-cover rounded-lg flex-shrink-0">
                    @else
                        <div class="w-14 h-14 bg-orange-100 rounded-lg flex items-center justify-center text-2xl flex-shrink-0">🔔</div>
                    @endif
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                {{ $report->status == 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                  ($report->status == 'process' ? 'bg-blue-100 text-blue-700' :
                                                                  'bg-green-100 text-green-700') }}">
                                {{ $report->status_label }}
                            </span>
                            <span class="text-xs text-gray-400">#{{ $report->id }}</span>
                        </div>
                        <p class="font-medium text-gray-800 text-sm">{{ $report->title }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            📍 {{ $report->location }} · 👤 {{ $report->reporter_name }} ·
                            {{ $report->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('reports.show', $report) }}"
                   class="bg-green-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-green-700 transition flex-shrink-0">
                    Tindaklanjuti
                </a>
            </div>
        @empty
            <div class="p-12 text-center text-gray-400">
                <p class="text-5xl mb-3">🎉</p>
                <p>Tidak ada laporan masalah!</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $reports->links() }}</div>
</div>

<footer class="bg-green-900 text-green-200 py-6 text-center text-sm mt-12">
    <p>© {{ date('Y') }} Desa Sejahtera</p>
</footer>
</body>
</html>