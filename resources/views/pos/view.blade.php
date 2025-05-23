@extends('layouts.master')

@section('title', 'View Sale')
@section('content')
    <div class="container">
        <h1>View Sale</h1>
        <a href="{{ route('pos.index') }}" class="btn btn-secondary mb-3">Back to POS</a>
        @include('pos.receipt', ['sales' => collect([$sale])])
    </div>
@endsection