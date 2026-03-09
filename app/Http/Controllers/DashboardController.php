<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense; // Pastikan Model Expense di-import
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
            
            // 1. Ambil input
            $categoryId = $request->query('category_id');
            $month = $request->query('month');
            $year = $request->query('year', date('Y')); // Default tahun semasa
            $sortBy = $request->query('sort_by', 'spent_at');
            $sortOrder = $request->query('sort_order', 'desc');

            $query = Expense::with('category')->where('user_id', $user->id);

            // 2. Filter Kategori
            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }

            // 3. Filter Bulan & Tahun
            if ($request->has('month') && $request->month != '') {
                $query->whereMonth('spent_at', $request->month);
            }

            // Hanya filter tahun kalau user ada pilih tahun kat dropdown/URL
            // Kalau tak pilih (default dashboard), dia tunjuk semua
            if ($request->has('year') && $request->year != '') {
                $query->whereYear('spent_at', $request->year);
            }
            
            // 4. Sorting & Get Data
            $expenses = $query->orderBy($sortBy, $sortOrder)->get();

            $categories = \App\Models\Category::where('user_id', $user->id)->get();
            $totalAmount = $expenses->sum('amount');

            return view('dashboard', compact('expenses', 'totalAmount', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'spent_at' => 'required|date',
            'description' => 'nullable|string',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        // Proses upload gambar kalau ada
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            $data['attachment'] = $path;
        }

        Expense::create($data);

        return redirect()->back()->with('success', 'Belanja berjaya disimpan!');
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->user_id !== auth()->id()) { abort(403); }

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'spent_at' => 'required|date',
            'description' => 'nullable|string',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('attachment')) {
            // Padam gambar lama kalau ada
            if ($expense->attachment) {
                Storage::disk('public')->delete($expense->attachment);
            }
            //simpan gambar baru
            $path = $request->file('attachment')->store('attachments', 'public');
            $data['attachment'] = $path;
        }

        $expense->update($data);

        return redirect()->back()->with('success', 'Rekod berjaya dikemaskini!');
    }

    public function destroy(Expense $expense)
    {
        // Pastikan user cuma boleh delete belanja milik dia sendiri
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $expense->delete();

        return redirect()->back()->with('success', 'Rekod berjaya dipadam!');
    }
}