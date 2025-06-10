@extends('layouts.master')

@section('title', 'View Sale Transaction')
@section('content')
    <div class="container">
        <h1>View Sale Transaction</h1>
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('pos.index') }}" class="btn btn-secondary">Back to POS</a>
        </div>
        @include('pos.receipt', ['saleTransaction' => $saleTransaction])
    </div>
@endsection