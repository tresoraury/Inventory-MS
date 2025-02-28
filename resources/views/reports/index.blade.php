@extends('layouts.master')

@section('content')
<style>
    .container {
        max-width: 600px;
        margin: 30px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    label {
        font-weight: bold;
        color: #555;
        flex-basis: 40%;
    }

    input[type="date"],
    select {
        flex-basis: 55%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    button {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #0056b3;
    }

    h2 {
        margin-top: 30px;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .no-reports {
        text-align: center;
        color: #777;
        font-style: italic;
    }
</style>

<div class="container">
    <h1>Generate Report</h1>

    <form action="{{ route('reports.generate') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="report_type">Report Type:</label>
            <select name="report_type" class="form-control" required>
                <option value="product">Product Report</option>
                <option value="operation">Operation Report</option>
                <option value="sale">Sales Report</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>

    @if(isset($reports))
        <h2>Generated Report</h2>
        <table class="table">
            <thead>
                <tr>
                    @if($report_type == 'product')
                        <th>Date</th>
                        <th>Product</th>
                        <th>Quantity Left</th>
                    @elseif($report_type == 'operation')
                        <th>Date</th>
                        <th>Operation Type</th>
                        <th>Issued By</th>
                        <th>Product</th>
                    @elseif($report_type == 'sale')
                        <th>Date</th>
                        <th>Materiaux Name</th>
                        <th>Quantity</th>
                        <th>Client Name</th>
                        <th>Total</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        @if($report_type == 'product')
                            <td>{{ $report->report_date }}</td>
                            <td>{{ $report->materiel->designation ?? 'N/A' }}</td>
                            <td>{{ $report->quantite }}</td>
                        @elseif($report_type == 'operation')
                            <td>{{ $report->report_date }}</td>
                            <td>{{ $report->type->name ?? 'N/A' }}</td>
                            <td>{{ $report->partenaire }}</td>
                            <td>{{ $report->materiel->designation ?? 'N/A' }}</td>
                        @elseif($report_type == 'sale')
                            <td>{{ $report->report_date }}</td>
                            <td>{{ $report->materiaux->designation ?? 'N/A' }}</td>
                            <td>{{ $report->quantity }}</td>
                            <td>{{ $report->client_name }}</td>
                            <td>{{ $report->total }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="no-reports">No reports found for the selected date range.</p>
    @endif
</div>

@endsection