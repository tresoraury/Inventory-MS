@extends('layouts.master')
@section('title', __('messages.pos_title'))
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ __('messages.pos_title') }}</h1>
        <a href="{{ route('pos.create') }}" class="btn btn-primary">{{ __('messages.add_sale') }}</a>
    </div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('sale_transaction_id'))
        @php
            $saleTransaction = App\Models\SaleTransaction::with(['sales.product', 'customer'])->find(session('sale_transaction_id'));
        @endphp
        @if ($saleTransaction)
            @include('pos.receipt', ['saleTransaction' => $saleTransaction])
        @else
            <div class="alert alert-warning">{{ __('messages.sale_transaction_not_found') }}</div>
        @endif
    @endif
    <h3>{{ __('messages.recent_sales') }}</h3>
    @if ($saleTransactions->isEmpty())
        <p>{{ __('messages.no_sales') }}</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('messages.transaction_id') }}</th>
                    <th>{{ __('messages.customer') }}</th>
                    <th>{{ __('messages.total_amount') }}</th>
                    <th>{{ __('messages.date') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($saleTransactions as $saleTransaction)
                    <tr>
                        <td>{{ $saleTransaction->id }}</td>
                        <td>{{ $saleTransaction->customer ? $saleTransaction->customer->name : 'N/A' }}</td>
                        <td>{{ number_format($saleTransaction->total_amount, 2) }}</td>
                        <td>{{ $saleTransaction->created_at ? $saleTransaction->created_at->format('Y-m-d') : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('pos.view', $saleTransaction) }}" class="btn btn-sm btn-info">{{ __('messages.view') }}</a>
                            <a href="{{ route('pos.edit', $saleTransaction) }}" class="btn btn-sm btn-primary">{{ __('messages.edit') }}</a>
                            <form action="{{ route('pos.destroy', $saleTransaction) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('messages.confirm_delete_sale') }}')">{{ __('messages.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection