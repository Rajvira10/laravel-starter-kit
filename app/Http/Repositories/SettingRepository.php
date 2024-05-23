<?php

namespace App\Http\Repositories;

use Carbon\Carbon;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingRepository
{
    public function index()
    {
        $settings = Setting::first();

        return $settings;
    }

    public function update($request)
    {
        $settings = Setting::first();

        if($settings == null)
        {
            $settings = new Setting();
        }

        if ($request->file('logo')) {
            $old_logo = $settings->logo;
            if($old_logo != null)
            {
                $old_logo_path = str_replace(asset('storage/'), '', $old_logo);
                Storage::disk('public')->delete($old_logo_path);
            }

            $logo = $request->file('logo');
            $logo_name = time() . '.' . $logo->getClientOriginalExtension();
            $logo_path = 'images/settings/' . $logo_name;
            Storage::disk('public')->put($logo_path, file_get_contents($logo));
            $absolute_path = asset('storage/' . $logo_path);
            $settings->logo = $absolute_path;
        }

        if($request->file('favicon')) {
            $old_favicon = $settings->favicon;
            if($old_favicon != null)
            {
                $old_favicon_path = str_replace(asset('storage/'), '', $old_favicon);
                Storage::disk('public')->delete($old_favicon_path);
            }

            $favicon = $request->file('favicon');
            $favicon_name = time() . '.' . $favicon->getClientOriginalExtension();
            $favicon_path = 'images/settings/' . $favicon_name;
            Storage::disk('public')->put($favicon_path, file_get_contents($favicon));
            $absolute_path = asset('storage/' . $favicon_path);
            $settings->favicon = $absolute_path;
        }

        $settings->brand_color = $request->brand_color;

        $settings->save();

    }
}