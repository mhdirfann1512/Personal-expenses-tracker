<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $now = now();

        // 1. Data Belanja Bulan Ni
        $thisMonthTotal = Expense::where('user_id', $userId)
            ->whereYear('spent_at', $now->year)
            ->whereMonth('spent_at', $now->month)
            ->sum('amount');

        // 2. Data Belanja Bulan Lepas
        $lastMonthTotal = Expense::where('user_id', $userId)
            ->whereYear('spent_at', $now->subMonth()->year)
            ->whereMonth('spent_at', $now->month) // Carbon subMonth dah gerakkan bulan ke belakang
            ->sum('amount');

        // 3. Kira Peratus Perbezaan
        $difference = $thisMonthTotal - $lastMonthTotal;
        $percentageChange = 0;
        if ($lastMonthTotal > 0) {
            $percentageChange = ($difference / $lastMonthTotal) * 100;
        }

        // 1. Data untuk Carta Pai (Belanja ikut Kategori)
        $categoryData = Expense::where('expenses.user_id', $userId) // <--- TAMBAH 'expenses.' kat depan user_id
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(expenses.amount) as total'), 'categories.color')
            ->groupBy('categories.name', 'categories.color')
            ->get();

        // 2. Data untuk Carta Bar (6 Bulan Terakhir)
        $monthlyData = Expense::where('user_id', $userId)
            ->select(
                DB::raw("DATE_FORMAT(spent_at, '%Y-%m') as sort_key"), // Kita buat key untuk susun (2024-01)
                DB::raw("DATE_FORMAT(spent_at, '%b %Y') as month"),    // Ini untuk display (Jan 2024)
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('sort_key', 'month') // Kumpulkan dua-dua sekali
            ->orderBy('sort_key', 'asc')   // Susun ikut tahun-bulan supaya urutan kalendar betul
            ->take(6)
            ->get();

            return view('analysis', compact(
                'categoryData', 
                'monthlyData', 
                'thisMonthTotal', 
                'lastMonthTotal', 
                'percentageChange',
                'difference'
            ));
    }
}