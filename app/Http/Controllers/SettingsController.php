<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:manage settings']);
    }

    public function index()
    {
        Log::debug('Settings index accessed', ['user_id' => Auth::id(), 'locale' => App::getLocale()]);
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        Log::debug('Settings update attempt', ['input' => $request->all(), 'current_locale' => App::getLocale()]);

        try {
            $request->validate([
                'language' => 'required|in:en,fr',
                'nif' => 'nullable|string|max:50',
                'company_name' => 'nullable|string|max:255',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'address' => 'nullable|string|max:500',
                'version' => 'nullable|string|max:50',
            ]);

            $user = Auth::user();
            $data = [
                'language' => $request->language,
                'nif' => $request->nif,
                'company_name' => $request->company_name,
                'address' => $request->address,
                'version' => $request->version,
            ];

            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Check directory permissions
                $directory = storage_path('app/public/logos');
                if (!is_writable($directory)) {
                    Log::error('Logo upload failed: Directory not writable', ['directory' => $directory]);
                    throw new \Exception('Logo upload failed: Storage directory is not writable.');
                }

                // Delete old logo if exists
                if ($user->logo && Storage::exists('public/' . $user->logo)) {
                    Storage::delete('public/' . $user->logo);
                    Log::debug('Old logo deleted', ['path' => $user->logo]);
                }

                // Store new logo
                $path = $request->file('logo')->store('logos', 'public');
                $data['logo'] = $path;
                Log::debug('Logo uploaded', ['path' => $path]);
            }

            $updated = $user->update($data);

            if ($updated) {
                Log::info('User settings updated', ['user_id' => $user->id, 'data' => $data]);
                
                Session::forget('locale');
                Cache::flush();
                Artisan::call('cache:clear');
                Artisan::call('clear-compiled');
                Session::regenerate();
                Auth::login($user);
                
                App::setLocale($request->language);
                Session::put('locale', $request->language);
                Log::debug('Locale set in controller', [
                    'locale' => $request->language,
                    'applied' => App::getLocale(),
                    'session' => Session::get('locale')
                ]);
                return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
            } else {
                Log::error('Failed to update settings', ['user_id' => $user->id]);
                return redirect()->route('settings.index')->with('error', 'Failed to update settings.');
            }
        } catch (\Exception $e) {
            Log::error('Settings update exception', ['error' => $e->getMessage(), 'user_id' => Auth::id()]);
            return redirect()->route('settings.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}