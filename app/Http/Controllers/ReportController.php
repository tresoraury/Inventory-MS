<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materiaux;
use App\Models\Produits;
use App\Models\Sale;

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
            'report_type' => 'required|in:product,operation,sale', 
        ]);

        $reports = [];
        $report_type = $request->report_type;

        if ($report_type == 'product') {
            $reports = Produits::whereBetween('date_operation', [$request->start_date, $request->end_date])
                ->with('materiel')
                ->get(['date_operation as report_date', 'materiel_id', 'quantite']);
        } elseif ($report_type == 'operation') {
            $reports = Produits::whereBetween('date_operation', [$request->start_date, $request->end_date])
                ->with(['materiel', 'type'])
                ->get(['date_operation as report_date', 'partenaire', 'materiel_id', 'quantite', 'type_operation']);
        } elseif ($report_type == 'sale') {
            $reports = Sale::where('created_at', '>=', $request->start_date)
                ->where('created_at', '<', date('Y-m-d', strtotime($request->end_date . ' +1 day')))
                ->with('materiaux')
                ->get(['id', 'materiaux_id', 'quantity', 'client_name', 'total', 'created_at as report_date']);
        }

        return view('reports.index', compact('reports', 'report_type'));
    }
}