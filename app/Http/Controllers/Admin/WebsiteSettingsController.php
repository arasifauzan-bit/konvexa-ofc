<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WebsiteSettingsController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'settings' => Setting::forWebsite(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $settings = $request->validate([
            'hero_badge' => ['required', 'string', 'max:100'],
            'hero_title' => ['required', 'string', 'max:120'],
            'hero_highlight' => ['required', 'string', 'max:120'],
            'hero_description' => ['required', 'string', 'max:1000'],
            'about_intro' => ['required', 'string', 'max:2000'],
            'about_commitment' => ['required', 'string', 'max:2000'],
            'location_name' => ['required', 'string', 'max:150'],
            'location_address' => ['required', 'string', 'max:1000'],
            'whatsapp_phone' => ['required', 'string', 'max:32', 'regex:/^\+?[0-9][0-9\s()-]{6,30}$/'],
            'contact_email' => ['required', 'email', 'max:255'],
            'instagram_url' => ['nullable', 'string', 'max:255', 'url', 'regex:/^https?:\/\//i'],
            'instagram_handle' => ['nullable', 'string', 'max:100'],
            'tiktok_url' => ['nullable', 'string', 'max:255', 'url', 'regex:/^https?:\/\//i'],
            'tiktok_handle' => ['nullable', 'string', 'max:100'],
        ]);

        DB::transaction(function () use ($settings): void {
            foreach ($settings as $key => $value) {
                Setting::query()->updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
        });

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Pengaturan website berhasil disimpan.');
    }
}
