@extends('layouts.master')
@section('title', 'Settings')
@section('content')
<div class="container-fluid">
    <h1 class="mt-4">{{ __('messages.settings') }}</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-cog mr-1"></i>
            {{ __('messages.settings') }}
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="language" class="form-label">{{ __('messages.language') }}</label>
                    <select name="language" id="language" class="form-select">
                        <option value="en" {{ auth()->user()->language === 'en' ? 'selected' : '' }}>English</option>
                        <option value="fr" {{ auth()->user()->language === 'fr' ? 'selected' : '' }}>French</option>
                    </select>
                    @error('language')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nif" class="form-label">NIF</label>
                    <input type="text" name="nif" id="nif" class="form-control" value="{{ old('nif', auth()->user()->nif ?? '') }}" maxlength="50">
                    @error('nif')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" name="company_name" id="company_name" class="form-control" value="{{ old('company_name', auth()->user()->company_name ?? '') }}" maxlength="255">
                    @error('company_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="logo" class="form-label">Company Logo</label>
                    <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                    @if (auth()->user()->logo)
                        <div class="mt-2">
                            <img src="{{ Storage::url(auth()->user()->logo) }}" alt="Company Logo" style="max-width: 100px; max-height: 100px;">
                        </div>
                    @endif
                    @error('logo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Company Address</label>
                    <textarea name="address" id="address" class="form-control" rows="4" maxlength="500">{{ old('address', auth()->user()->address ?? '') }}</textarea>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="version" class="form-label">System Version</label>
                    <input type="text" name="version" id="version" class="form-control" value="{{ old('version', auth()->user()->version ?? '') }}" maxlength="50">
                    @error('version')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
        </div>
    </div>
</div>
@endsection