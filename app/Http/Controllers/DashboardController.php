<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $lowStock = Product::whereRaw('stock_quantity < minimum_quantity')->count();
        return view('admin.dashboard', compact('totalProducts', 'lowStock'));
    }
}