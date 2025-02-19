<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materiaux;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $inventoryLevels = Materiaux::select('id', 'designation', 'stock_level')->get();

        $salesTrends = Sale::select(DB::raw('DATE(created_at) as date, SUM(total) as total_sales'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $bestSellingProducts = Sale::select('product_id', DB::raw('COUNT(*) as count'))
            ->groupBy('product_id')
            ->orderBy('count', 'desc')
            ->take(3)
            ->get();

        return view('reports.index', compact('inventoryLevels','salesTrends', 'bestSellingProducts'));
    }
}
