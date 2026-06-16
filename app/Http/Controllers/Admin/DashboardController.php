<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => \App\Models\Product::count(),
            'total_categories' => \App\Models\Category::count(),
            'total_transactions' => \App\Models\Transaction::count(),
            'low_stock_count' => \App\Models\Product::where('stock', '<', 5)->count(),
        ];
        $lowStockProducts = \App\Models\Product::where('stock', '<', 5)->with('category')->get();
        return view('admin.dashboard', compact('stats', 'lowStockProducts'));
    }
}
