<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()->expenses()->with('category');

        // Filter ikut kod web
        if ($request->month) $query->whereMonth('spent_at', $request->month);
        if ($request->year) $query->whereYear('spent_at', $request->year);
        if ($request->category_id) $query->where('category_id', $request->category_id);

        // Sort ikut sort_by dan sort_order
        $query->orderBy($request->sort_by ?? 'spent_at', $request->sort_order ?? 'desc');

        return response()->json(['data' => $query->get()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'spent_at' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $expense = $request->user()->expenses()->create($validated);

        return response()->json([
            'message' => 'Berjaya simpan!',
            'data' => $expense
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Pastikan user cuma boleh edit expense milik dia sahaja
        $expense = $request->user()->expenses()->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'spent_at' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $expense->update($validated);

        return response()->json([
            'message' => 'Berjaya dikemaskini',
            'data' => $expense->load('category')
            ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $expense = $request->user()->expenses()->findOrFail($id);
        $expense->delete();
        return response()->json(['message' => 'Berjaya dipadam']);
    }
}