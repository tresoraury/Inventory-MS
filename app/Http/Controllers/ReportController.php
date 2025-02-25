<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materiaux;
use App\Models\Produits;
use App\Models\Report;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $inventoryLevels = Materiaux::all();
        $salesTrends = []; 
        $bestSellingProducts = []; 

        return view('reports.index', compact('inventoryLevels', 'salesTrends', 'bestSellingProducts'));
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'report_type' => 'required|in:product,operation',
        ]);

        $inventoryLevels = Materiaux::all();

        $bestSellingProducts = Produits::select('materiel_id', \DB::raw('COUNT(*) as count'))
            ->whereBetween('date_operation', [$request->start_date, $request->end_date])
            ->groupBy('materiel_id')
            ->orderBy('count', 'DESC')
            ->take(5)
            ->get();

        $salesTrends = Produits::select(\DB::raw('date_operation as date'), \DB::raw('SUM(quantite) as total_sales'))
            ->whereBetween('date_operation', [$request->start_date, $request->end_date])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $reports = [];
        $report_type = $request->report_type;

        if ($report_type == 'product') {
            $reports = Produits::whereBetween('date_operation', [$request->start_date, $request->end_date])
                ->with('materiel')
                ->get(['date_operation as report_date', 'materiel_id', 'quantite']);
        } elseif ($report_type == 'operation') {
            $reports = Produits::whereBetween('date_operation', [$request->start_date, $request->end_date])
                ->with(['materiel', 'type']) 
                ->get(['date_operation as report_date', 'type_operation', 'partenaire']);
        }

        return view('reports.index', compact('inventoryLevels', 'reports', 'report_type', 'bestSellingProducts', 'salesTrends'));
    }
}