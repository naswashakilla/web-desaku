<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    // Halaman daftar pengumuman (untuk warga, publik)
    public function index()
{
    $announcements = Announcement::published()
        ->with('author')
        ->latest()
        ->paginate(10);

    return view('announcements.index', compact('announcements'));
}

    // Halaman detail satu pengumuman
    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }

    // Form buat pengumuman baru (admin only)
    public function create()
    {
        return view('announcements.create');
    }

    // Simpan pengumuman baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|max:255',
            'content'  => 'required',
            'category' => 'required',
            'image'    => 'nullable|image|max:2048', // max 2MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcements', 'public');
        }

        Announcement::create([
            'title'        => $request->title,
            'content'      => $request->content,
            'category'     => $request->category,
            'image'        => $imagePath,
            'is_published' => $request->has('is_published'),
            'user_id'      => auth()->id(),
        ]);

        return redirect()->route('announcements.index')
            ->with('success', 'Pengumuman berhasil dibuat!');
    }

    // Form edit pengumuman (admin only)
    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', compact('announcement'));
    }

    // Update pengumuman di database
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title'    => 'required|max:255',
            'content'  => 'required',
            'category' => 'required',
            'image'    => 'nullable|image|max:2048',
        ]);

        $imagePath = $announcement->image;
        if ($request->hasFile('image')) {
            // hapus gambar lama jika ada
            if ($imagePath) Storage::disk('public')->delete($imagePath);
            $imagePath = $request->file('image')->store('announcements', 'public');
        }

        $announcement->update([
            'title'        => $request->title,
            'content'      => $request->content,
            'category'     => $request->category,
            'image'        => $imagePath,
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('announcements.index')
            ->with('success', 'Pengumuman berhasil diperbarui!');
    }

    // Hapus pengumuman
    public function destroy(Announcement $announcement)
    {
        if ($announcement->image) {
            Storage::disk('public')->delete($announcement->image);
        }
        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus!');
    }
}