@if (!isset($printMode) || !$printMode)
    @extends('layouts.master')
    @section('content')
        <div class="container">
            <div class="receipt-container">
                <div class="receipt-header">
                    <h3>{{ auth()->user()->company_name ?? 'Inventory MS' }} - Sale Receipt</h3>
                    @if (auth()->user()->nif)
                        <p><strong>NIF:</strong> {{ auth()->user()->nif }}</p>
                    @endif
                </div>
                <p><strong>Date:</strong> {{ $saleTransaction->created_at ? $saleTransaction->created_at->format('Y-m-d H:i:s') : 'N/A' }}</p>
                <table class="table table-bordered receipt-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saleTransaction->sales as $sale)
                            <tr>
                                <td>{{ $sale->product ? $sale->product->name . ' (' . $sale->product->code . ')' : 'N/A' }}</td>
                                <td>{{ $sale->quantity }}</td>
                                <td>{{ number_format($sale->price / $sale->quantity, 2) }}</td>
                                <td>{{ number_format($sale->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="total"><strong>Grand Total:</strong> {{ number_format($saleTransaction->total_amount, 2) }}</p>
                <p class="customer"><strong>Customer:</strong> {{ $saleTransaction->customer ? $saleTransaction->customer->name : 'N/A' }}</p>
                <p class="thank-you">Thank you for your purchase!</p>
                <button onclick="printReceipt()" class="btn btn-primary print-button">Print Receipt</button>
            </div>
        </div>
        <style>
            .receipt-container {
                max-width: 80mm;
                margin: 0 auto;
                text-align: center;
            }
            .receipt-header {
                margin-bottom: 15px;
            }
            .receipt-table {
                width: 100%;
                margin-bottom: 15px;
            }
            .total, .customer {
                text-align: right;
                margin: 10px 0;
            }
            .thank-you {
                margin-top: 15px;
                text-align: center;
            }
        </style>
        <script>
            function printReceipt() {
                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
                    <head>
                        <meta charset="UTF-8">
                        <title>Sale Receipt</title>
                        <style>
                            body {
                                font-family: 'Courier New', Courier, monospace;
                                width: 80mm;
                                margin: 0;
                                padding: 5mm;
                                line-height: 1.2;
                                font-size: 12pt;
                                color: #000;
                            }
                            .receipt-container {
                                width: 100%;
                                text-align: center;
                            }
                            .receipt-header {
                                margin-bottom: 5mm;
                            }
                            .receipt-table {
                                width: 100%;
                                border-collapse: collapse;
                                margin-bottom: 5mm;
                            }
                            .receipt-table th, .receipt-table td {
                                border: 1px solid #000;
                                padding: 2mm;
                                text-align: left;
                            }
                            .receipt-table th {
                                font-weight: bold;
                            }
                            .total, .customer {
                                text-align: right;
                                margin: 2mm 0;
                            }
                            .thank-you {
                                margin-top: 5mm;
                                text-align: center;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="receipt-container">
                            <div class="receipt-header">
                                <h3>{{ auth()->user()->company_name ?? 'Inventory MS' }} - Sale Receipt</h3>
                                @if (auth()->user()->nif)
                                    <p><strong>NIF:</strong> {{ auth()->user()->nif }}</p>
                                @endif
                            </div>
                            <p><strong>Date:</strong> {{ $saleTransaction->created_at ? $saleTransaction->created_at->format('Y-m-d H:i:s') : 'N/A' }}</p>
                            <table class="receipt-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($saleTransaction->sales as $sale)
                                        <tr>
                                            <td>{{ $sale->product ? $sale->product->name . ' (' . $sale->product->code . ')' : 'N/A' }}</td>
                                            <td>{{ $sale->quantity }}</td>
                                            <td>{{ number_format($sale->price / $sale->quantity, 2) }}</td>
                                            <td>{{ number_format($sale->price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <p class="total"><strong>Grand Total:</strong> {{ number_format($saleTransaction->total_amount, 2) }}</p>
                            <p class="customer"><strong>Customer:</strong> {{ $saleTransaction->customer ? $saleTransaction->customer->name : 'N/A' }}</p>
                            <p class="thank-you">Thank you for your purchase!</p>
                        </div>
                    </body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.print();
                printWindow.close();
            }
        </script>
    @endsection
@else
    <div class="receipt-container">
        <div class="receipt-header">
            <h3>{{ auth()->user()->company_name ?? 'Inventory MS' }} - Sale Receipt</h3>
            @if (auth()->user()->nif)
                <p><strong>NIF:</strong> {{ auth()->user()->nif }}</p>
            @endif
        </div>
        <p><strong>Date:</strong> {{ $saleTransaction->created_at ? $saleTransaction->created_at->format('Y-m-d H:i:s') : 'N/A' }}</p>
        <table class="receipt-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($saleTransaction->sales as $sale)
                    <tr>
                        <td>{{ $sale->product ? $sale->product->name . ' (' . $sale->product->code . ')' : 'N/A' }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>{{ number_format($sale->price / $sale->quantity, 2) }}</td>
                        <td>{{ number_format($sale->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="total"><strong>Grand Total:</strong> {{ number_format($saleTransaction->total_amount, 2) }}</p>
        <p class="customer"><strong>Customer:</strong> {{ $saleTransaction->customer ? $saleTransaction->customer->name : 'N/A' }}</p>
        <p class="thank-you">Thank you for your purchase!</p>
    </div>
@endif