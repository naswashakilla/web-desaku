<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Website Desa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg">D</div>
            <div>
                <p class="font-bold text-green-800 leading-tight">Desa Sejahtera</p>
                <p class="text-xs text-gray-400">Portal Informasi Warga</p>
            </div>
        </a>
        <div class="flex gap-4 text-sm items-center">
            <a href="/" class="text-gray-600 hover:text-green-700">Beranda</a>
            <a href="/pengumuman" class="text-gray-600 hover:text-green-700">Pengumuman</a>
            @auth
                <a href="/dashboard" class="text-gray-600 hover:text-green-700">Dashboard</a>
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button class="text-red-500 text-sm hover:underline">Logout</button>
                </form>
            @else
                <a href="/login" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">Login</a>
            @endauth
        </div>
    </div>
</nav>

<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-2">Selamat datang, {{ auth()->user()->name }}! 👋</h1>
    <p class="text-gray-500 mb-8">Kamu sudah login sebagai admin website desa.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="/admin/pengumuman/buat"
           class="bg-white border rounded-lg p-5 hover:shadow transition">
            <div class="text-3xl mb-2">📢</div>
            <h2 class="font-semibold">Buat Pengumuman</h2>
            <p class="text-sm text-gray-500 mt-1">Tambah pengumuman baru untuk warga</p>
        </a>
        <a href="/pengumuman"
           class="bg-white border rounded-lg p-5 hover:shadow transition">
            <div class="text-3xl mb-2">📋</div>
            <h2 class="font-semibold">Lihat Pengumuman</h2>
            <p class="text-sm text-gray-500 mt-1">Daftar semua pengumuman desa</p>
        </a>
        <a href="/keuangan"
            class="bg-white border rounded-lg p-5 hover:shadow transition">
                <div class="text-3xl mb-2">💰</div>
                <h2 class="font-semibold">Keuangan Desa</h2>
                <p class="text-sm text-gray-500 mt-1">Iuran, kas, dan transaksi RT</p>
        </a>
        <a href="/admin/laporan"
           class="bg-white border rounded-lg p-5 hover:shadow transition">
            <div class="text-3xl mb-2">⚙️</div>
            <h2 class="font-semibold">Kelola Laporan</h2>
            <p class="text-sm text-gray-500 mt-1">Tindaklanjuti laporan masalah warga</p>
    </div>
</div>

</body>
</html>