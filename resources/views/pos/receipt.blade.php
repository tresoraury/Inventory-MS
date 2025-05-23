<div class="card mt-3 receipt-container" id="receipt">
    <div class="card-body">
        <h5 class="card-title text-center">Inventory MS - Sale Receipt</h5>
        <p class="text-center">Date: {{ now()->format('Y-m-d H:i:s') }}</p>
        @if (count($sales) > 0)
            <table class="table receipt-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr>
                            <td>{{ $sale->product ? $sale->product->name . ' (' . $sale->product->code . ')' : 'N/A' }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>{{ $sale->product ? number_format($sale->price / $sale->quantity, 2) : 'N/A' }}</td>
                            <td>{{ number_format($sale->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Grand Total:</th>
                        <th>{{ number_format(collect($sales)->sum('price'), 2) }}</th>
                    </tr>
                </tfoot>
            </table>
            <p><strong>Customer:</strong> {{ $sales[0]->customer ? $sales[0]->customer->name : 'N/A' }}</p>
        @else
            <p>No sale items to display.</p>
        @endif
        <hr>
        <p class="text-center">Thank you for your purchase!</p>
        <div class="text-center">
            <button class="btn btn-primary no-print" onclick="printReceipt()">Print Receipt</button>
        </div>
    </div>
</div>

<style>
    .receipt-container {
        max-width: 400px;
        margin: 0 auto;
    }
    .receipt-table {
        width: 100%;
        border-collapse: collapse;
    }
    .receipt-table th, .receipt-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }
    .receipt-table th.text-end, .receipt-table td.text-end {
        text-align: right;
    }
    @media print {
        body * {
            visibility: hidden;
        }
        .receipt-container, .receipt-container * {
            visibility: visible;
        }
        .receipt-container {
            position: absolute;
            left: 0;
            top: 0;
            max-width: 100%;
            border: none;
            box-shadow: none;
            font-size: 14px;
        }
        .card-body {
            padding: 10px;
        }
        .no-print {
            display: none !important;
        }
        .receipt-table th, .receipt-table td {
            border: 1px solid #000;
            padding: 6px;
        }
    }
</style>

<script>
    function printReceipt() {
        window.print();
    }
</script>