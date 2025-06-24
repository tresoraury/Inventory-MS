@extends('layouts.master')
@section('title', __('messages.settings_title'))
@section('content')
<div class="container-fluid">
    <!-- Debug Information 
    <div class="alert alert-info">
        <p><strong>Debug Info:</strong></p>
        <p>Current Locale: {{ App::getLocale() }}</p>
        <p>Session Locale: {{ Session::get('locale') }}</p>
        <p>Config Locale: {{ Config::get('app.locale') }}</p>
        <p>Test Translation (settings_title): {{ __('messages.settings_title') }}</p>
        <p>User Language: {{ auth()->user()->language }}</p>
    </div>
     End Debug Information -->

    <h1 class="mt-4">{{ __('messages.settings_title') }}</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-cog mr-1"></i>{{ __('messages.settings_title') }}
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="language" class="form-label">{{ __('messages.language') }}</label>
                    <select name="language" id="language" class="form-select">
                        <option value="en" {{ auth()->user()->language === 'en' ? 'selected' : '' }}>{{ __('messages.english') }}</option>
                        <option value="fr" {{ auth()->user()->language === 'fr' ? 'selected' : '' }}>{{ __('messages.french') }}</option>
                    </select>
                    @error('language')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nif" class="form-label">{{ __('messages.nif') }}</label>
                    <input type="text" name="nif" id="nif" class="form-control" value="{{ old('nif', auth()->user()->nif ?? '') }}" maxlength="50">
                    @error('nif')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="company_name" class="form-label">{{ __('messages.company_name') }}</label>
                    <input type="text" name="company_name" id="company_name" class="form-control" value="{{ old('company_name', auth()->user()->company_name ?? '') }}" maxlength="255">
                    @error('company_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="logo" class="form-label">{{ __('messages.company_logo') }}</label>
                    <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                    @if (auth()->user()->logo)
                        <div class="mt-2">
                            <img src="{{ Storage::url(auth()->user()->logo) }}" alt="{{ __('messages.company_logo') }}" style="max-width: 100px; max-height: 100px;">
                        </div>
                    @endif
                    @error('logo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">{{ __('messages.company_address') }}</label>
                    <textarea name="address" id="address" class="form-control" rows="4" maxlength="500">{{ old('address', auth()->user()->address ?? '') }}</textarea>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="version" class="form-label">{{ __('messages.system_version') }}</label>
                    <input type="text" name="version" id="version" class="form-control" value="{{ old('version', auth()->user()->version ?? '') }}" maxlength="50">
                    @error('version')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">{{ __('messages.save_settings') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection