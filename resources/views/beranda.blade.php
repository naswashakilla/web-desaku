<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Sejahtera - Portal Informasi Warga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-bg { background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1600') center/cover; }
    </style>
</head>
<body class="bg-gray-50 font-sans">

{{-- Top Bar --}}
<div class="bg-green-800 text-green-100 text-xs py-2 px-6 flex justify-between">
    <span>📍 Jl. Raya Desa No. 1, Kecamatan Sejahtera</span>
    <span>✉️ desa.sejahtera@gmail.com</span>
</div>

{{-- Navbar --}}
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg">D</div>
            <div>
                <p class="font-bold text-green-800 leading-tight">Desa Sejahtera</p>
                <p class="text-xs text-gray-400">Portal Informasi Warga</p>
            </div>
        </div>
        <div class="hidden md:flex gap-6 text-sm font-medium">
            <a href="/" class="text-green-700 border-b-2 border-green-600 pb-1">Beranda</a>
            <a href="/pengumuman" class="text-gray-600 hover:text-green-700 transition">Pengumuman</a>
            <a href="#layanan" class="text-gray-600 hover:text-green-700 transition">Layanan</a>
            <a href="#kontak" class="text-gray-600 hover:text-green-700 transition">Kontak</a>
            <a href="/keuangan" class="text-gray-600 hover:text-green-700 transition">Keuangan</a>
        </div>
        @auth
            <a href="/dashboard" class="bg-green-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-green-700 transition">Dashboard</a>
        @else
            <a href="/login" class="bg-green-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-green-700 transition">Login</a>
        @endauth
    </div>
</nav>

{{-- Hero --}}
<section class="hero-bg min-h-screen flex items-center justify-center text-center text-white px-4" style="min-height: 600px">
    <div>
        <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full uppercase tracking-widest">Portal Resmi Desa</span>
        <h1 class="text-5xl font-bold mt-4 mb-4 leading-tight">Selamat Datang di<br>Desa Sejahtera</h1>
        <p class="text-green-100 text-lg mb-8 max-w-xl mx-auto">Temukan informasi, layanan, dan pengumuman terbaru untuk seluruh warga desa secara digital.</p>
        <div class="flex gap-4 justify-center">
            <a href="/pengumuman" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition">Lihat Pengumuman</a>
            <a href="#layanan" class="border border-white text-white hover:bg-white hover:text-green-800 px-6 py-3 rounded-lg font-medium transition">Layanan Kami</a>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="bg-white py-8 shadow-sm">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        <div>
            <p class="text-3xl font-bold text-green-700">1.200+</p>
            <p class="text-sm text-gray-500 mt-1">Warga Terdaftar</p>
        </div>
        <div>
            <p class="text-3xl font-bold text-green-700">350+</p>
            <p class="text-sm text-gray-500 mt-1">Kepala Keluarga</p>
        </div>
        <div>
            <p class="text-3xl font-bold text-green-700">12</p>
            <p class="text-sm text-gray-500 mt-1">RT Aktif</p>
        </div>
        <div>
            <p class="text-3xl font-bold text-green-700">4</p>
            <p class="text-sm text-gray-500 mt-1">RW</p>
        </div>
    </div>
</section>

{{-- Layanan --}}
<section id="layanan" class="py-16 px-4 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <p class="text-center text-green-600 text-sm font-semibold uppercase tracking-widest mb-2">Apa yang kami sediakan</p>
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Layanan Digital Desa</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">

            <a href="/pengumuman" class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition border border-gray-100 group">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:bg-green-600 transition">📢</div>
                <h3 class="font-semibold text-gray-800 mb-2">Pengumuman</h3>
                <p class="text-sm text-gray-500">Informasi dan berita terbaru dari pengurus desa untuk seluruh warga.</p>
                <span class="text-green-600 text-sm mt-3 inline-block">Lihat sekarang →</span>
            </a>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 opacity-60">
                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-2xl mb-4">📄</div>
                <h3 class="font-semibold text-gray-800 mb-2">Surat Online</h3>
                <p class="text-sm text-gray-500">Ajukan permohonan surat keterangan tanpa perlu antri di kantor.</p>
                <span class="text-gray-400 text-sm mt-3 inline-block">Segera hadir</span>
            </div>


            <a href="/laporan" class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition border border-gray-100 group">
                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-2xl mb-4">🔔</div>
                <h3 class="font-semibold text-gray-800 mb-2">Laporan Masalah</h3>
                <p class="text-sm text-gray-500">Laporkan masalah lingkungan di sekitar rumahmu dengan mudah.</p>
                <span class="text-green-600 text-sm mt-3 inline-block">Lihat sekarang →</span>
            </a>

            <a href="/keuangan" class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition border border-gray-100 group">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:bg-green-600 transition">💰</div>
                <h3 class="font-semibold text-gray-800 mb-2">Keuangan Desa</h3>
                <p class="text-sm text-gray-500">Transparansi kas dan iuran warga secara digital dan real-time.</p>
                <span class="text-green-600 text-sm mt-3 inline-block">Lihat sekarang →</span>
            </a>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 opacity-60">
                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-2xl mb-4">🏠</div>
                <h3 class="font-semibold text-gray-800 mb-2">Direktori Warga</h3>
                <p class="text-sm text-gray-500">Data penduduk dan UMKM lokal dalam satu direktori lengkap.</p>
                <span class="text-gray-400 text-sm mt-3 inline-block">Segera hadir</span>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 opacity-60">
                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-2xl mb-4">♻️</div>
                <h3 class="font-semibold text-gray-800 mb-2">Bank Sampah</h3>
                <p class="text-sm text-gray-500">Setor sampah, kumpulkan poin, dan tukar dengan hadiah menarik.</p>
                <span class="text-gray-400 text-sm mt-3 inline-block">Segera hadir</span>
            </div>

        </div>
    </div>
</section>

{{-- Pengumuman Terbaru --}}
<section class="py-16 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <p class="text-green-600 text-sm font-semibold uppercase tracking-widest mb-1">Terkini</p>
                <h2 class="text-3xl font-bold text-gray-800">Pengumuman Terbaru</h2>
            </div>
            <a href="/pengumuman" class="text-green-600 text-sm hover:underline">Lihat semua →</a>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @php
                $latest = \App\Models\Announcement::published()->latest()->take(3)->get();
            @endphp
            @forelse($latest as $item)
                <a href="{{ route('announcements.show', $item) }}"
                   class="bg-gray-50 rounded-xl overflow-hidden border border-gray-100 hover:shadow-md transition group">
                    @if($item->image)
                        <img src="{{ Storage::url($item->image) }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gradient-to-br from-green-400 to-green-700 flex items-center justify-center text-4xl">📢</div>
                    @endif
                    <div class="p-4">
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">{{ ucfirst($item->category) }}</span>
                        <h3 class="font-semibold text-gray-800 mt-2 group-hover:text-green-700 transition">{{ $item->title }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($item->content, 80) }}</p>
                        <p class="text-xs text-gray-400 mt-3">{{ $item->created_at->diffForHumans() }}</p>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center py-8 text-gray-400">
                    <p>Belum ada pengumuman.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Kontak --}}
<section id="kontak" class="py-16 px-4 bg-green-800 text-white">
    <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8 text-center">
        <div>
            <div class="text-3xl mb-3">📞</div>
            <h3 class="font-semibold mb-1">Telepon</h3>
            <p class="text-green-200 text-sm">(0xx) xxxx-xxxx</p>
        </div>
        <div>
            <div class="text-3xl mb-3">✉️</div>
            <h3 class="font-semibold mb-1">Email</h3>
            <p class="text-green-200 text-sm">desa.sejahtera@gmail.com</p>
        </div>
        <div>
            <div class="text-3xl mb-3">🕒</div>
            <h3 class="font-semibold mb-1">Jam Pelayanan</h3>
            <p class="text-green-200 text-sm">Senin–Jumat: 08.00–16.00</p>
        </div>
    </div>
</section>

{{-- Footer --}}
<footer class="bg-green-900 text-green-200 py-6 text-center text-sm">
    <p>© {{ date('Y') }} Desa Sejahtera · Semua hak dilindungi</p>
</footer>

</body>
</html>