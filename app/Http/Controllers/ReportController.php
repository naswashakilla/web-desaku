<?php
namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    // Daftar semua laporan (publik)
    public function index()
    {
        $reports = Report::latest()->paginate(10);

        $totalPending = Report::where('status', 'pending')->count();
        $totalProcess = Report::where('status', 'process')->count();
        $totalDone    = Report::where('status', 'done')->count();

        return view('reports.index', compact(
            'reports', 'totalPending', 'totalProcess', 'totalDone'
        ));
    }

    // Form buat laporan (publik, tanpa login)
    public function create()
    {
        return view('reports.create');
    }

    // Simpan laporan baru
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|max:255',
            'category'       => 'required|max:255',
            'description'    => 'required',
            'location'       => 'required|max:255',
            'reporter_name'  => 'required|max:255',
            'reporter_phone' => 'nullable|max:20',
            'photo'          => 'nullable|image|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('reports', 'public');
        }

        $report = Report::create([
            'title'          => $request->title,
            'category'       => $request->category,
            'description'    => $request->description,
            'location'       => $request->location,
            'reporter_name'  => $request->reporter_name,
            'reporter_phone' => $request->reporter_phone,
            'photo'          => $photoPath,
            'status'         => 'pending',
        ]);

        // Otomatis buat update pertama
        ReportUpdate::create([
            'report_id' => $report->id,
            'user_id'   => 1, // default admin pertama
            'status'    => 'pending',
            'note'      => 'Laporan diterima, menunggu ditindaklanjuti.',
        ]);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Laporan berhasil dikirim! Catat nomor laporan kamu: #'.$report->id);
    }

    // Detail laporan
    public function show(Report $report)
    {
        $updates = $report->updates()->with('admin')->latest()->get();
        return view('reports.show', compact('report', 'updates'));
    }

    // Admin update status laporan
    public function updateStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:pending,process,done',
            'note'   => 'required|string',
        ]);

        $report->update(['status' => $request->status]);

        ReportUpdate::create([
            'report_id' => $report->id,
            'user_id'   => auth()->id(),
            'status'    => $request->status,
            'note'      => $request->note,
        ]);

        return back()->with('success', 'Status laporan berhasil diperbarui!');
    }

    // Daftar laporan untuk admin
    public function adminIndex()
    {
        $reports = Report::latest()->paginate(15);
        return view('reports.admin', compact('reports'));
    }
}