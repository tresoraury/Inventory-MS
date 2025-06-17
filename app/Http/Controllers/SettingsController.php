<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:manage settings']);
    }

    public function index()
    {
        Log::debug('Settings index accessed by user: ' . Auth::id());
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        Log::debug('Settings update attempt', $request->all());

        try {
            $request->validate([
                'language' => 'required|in:en,fr',
                'nif' => 'nullable|string|max:50',
                'company_name' => 'nullable|string|max:255',
            ]);

            $user = Auth::user();
            $updated = $user->update([
                'language' => $request->language,
                'nif' => $request->nif,
                'company_name' => $request->company_name,
            ]);

            if ($updated) {
                Log::info('User settings updated', ['user_id' => $user->id, 'data' => $request->all()]);
                // Refresh user session
                Auth::setUser($user);
                Auth::login($user);
                App::setLocale($request->language);
                Session::put('locale', $request->language);
                return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
            } else {
                Log::error('Failed to update user settings', ['user_id' => $user->id]);
                return redirect()->route('settings.index')->with('error', 'Failed to update settings.');
            }
        } catch (\Exception $e) {
            Log::error('Settings update exception', ['error' => $e->getMessage(), 'user_id' => Auth::id()]);
            return redirect()->route('settings.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}