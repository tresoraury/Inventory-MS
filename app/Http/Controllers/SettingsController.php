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
use Illuminate\Support\Facades\Config; 

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:manage settings']);
    }

    public function index()
    {
        Log::info('Settings index accessed', [
            'user_id' => Auth::id(),
            'locale' => App::getLocale(),
            'session_locale' => Session::get('locale'),
            'user_language' => Auth::user()->language ?? 'none'
        ]);
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        Log::info('Settings update attempt', [
            'input' => $request->all(),
            'current_locale' => App::getLocale(),
            'session_locale' => Session::get('locale')
        ]);

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

            
            if ($request->hasFile('logo')) {
                $directory = storage_path('app/public/logos');
                if (!is_writable($directory)) {
                    Log::error('Logo upload failed: Directory not writable', ['directory' => $directory]);
                    throw new \Exception(__('messages.logo_upload_failed'));
                }
                if ($user->logo && Storage::exists('public/' . $user->logo)) {
                    Storage::delete('public/' . $user->logo);
                    Log::info('Old logo deleted', ['path' => $user->logo]);
                }
                $path = $request->file('logo')->store('logos', 'public');
                $data['logo'] = $path;
                Log::info('Logo uploaded', ['path' => $path]);
            }

            $updated = $user->update($data);
            if ($updated) {
                
                $freshUser = $user->fresh();
                Auth::setUser($freshUser);

                
                App::setLocale($request->language);
                Session::put('locale', $request->language);

                
                Cache::flush();
                Artisan::call('cache:clear');
                Artisan::call('config:clear');

                Log::info('User settings updated and locale set', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'data' => $data,
                    'locale' => App::getLocale(),
                    'session_locale' => Session::get('locale'),
                    'config_locale' => Config::get('app.locale'),
                    'user_language' => $freshUser->language
                ]);

                return redirect()->route('settings.index')
                    ->with('success', __('messages.settings_updated'));
            } else {
                Log::error('Failed to update settings', ['user_id' => $user->id]);
                return redirect()->route('settings.index')
                    ->with('error', __('messages.settings_failed'));
            }
        } catch (\Exception $e) {
            Log::error('Settings update exception', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);
            return redirect()->route('settings.index')
                ->with('error', __('messages.settings_error', ['error' => $e->getMessage()]));
        }
    }
}