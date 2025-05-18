@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="alert alert-warning text-center custom-alert">
        <h4 class="alert-heading">Access Denied</h4>
        @if (session('status'))
            <p>{{ session('status') }}</p>
        @else
            <p>It seems you do not have permission to access this system.</p>
            <p>Please contact your administrator for assistance.</p>
        @endif
    </div>
</div>

<style>
    .custom-alert {
        background-color: #fff3cd;
        border-color: #ffeeba;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 600

px;
        margin: 0 auto;
    }

    .alert-heading {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    p {
        font-size: 1rem;
        margin: 0;
    }
</style>
@endsection