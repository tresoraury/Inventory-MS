<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Sale;
use App\Models\SaleTransaction;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function products(Request $request)
    {
        $query = Product::with('category', 'supplier');
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');
            $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
        }
        $products = $query->get();
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        return view('admin.reports.products', compact('products', 'startDate', 'endDate'));
    }

    public function operations(Request $request)
    {
        $query = Operation::with('product', 'operationType', 'supplier');
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');
            $query->whereBetween('operation_date', [$startDate, $endDate]);
        }
        $operations = $query->get();
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        return view('admin.reports.operations', compact('operations', 'startDate', 'endDate'));
    }

    public function sales(Request $request)
    {
        $query = SaleTransaction::with(['sales.product', 'customer']);
        $totalSales = 0;

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');
            $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
        }

        $saleTransactions = $query->get();
        $totalSales = $saleTransactions->sum('total_amount');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        return view('admin.reports.sales', compact('saleTransactions', 'totalSales', 'startDate', 'endDate'));
    }

    public function suppliers(Request $request)
    {
        $suppliers = Supplier::all();
        $products = collect();
        $selectedSupplier = null;
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        if ($request->has('supplier_id')) {
            $supplierId = $request->query('supplier_id');
            $selectedSupplier = Supplier::find($supplierId);
            $query = Product::where('supplier_id', $supplierId)->with('category', 'supplier');
            if ($request->has('start_date') && $request->has('end_date')) {
                $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
            }
            $products = $query->get();
        }

        return view('admin.reports.suppliers', compact('suppliers', 'products', 'selectedSupplier', 'startDate', 'endDate'));
    }

    public function purchaseOrders(Request $request)
    {
        $query = PurchaseOrder::with(['items.product', 'supplier']);
        $totalPurchaseOrders = 0;

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');
            $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
        }

        $purchaseOrders = $query->get();
        $totalPurchaseOrders = $purchaseOrders->sum('total_amount');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        return view('admin.reports.purchase_orders', compact('purchaseOrders', 'totalPurchaseOrders', 'startDate', 'endDate'));
    }
}