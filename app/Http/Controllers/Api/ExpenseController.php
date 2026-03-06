<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        // Ambil belanja user yang tengah login melalui API
        $expenses = $request->user()->expenses()->with('category')->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $expenses
        ]);
    }
}