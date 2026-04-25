<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSettings;

class SiteSettingsController extends Controller
{
    public function show()
    {
        try {
            $settings = SiteSettings::firstOrFail();

            return response()->json($settings);
        } catch (\Throwable $e) {
            return response()->json([
                'site_name' => 'Ethos Studio',
                'tagline' => null,
                'footer_email' => null,
                'copyright' => null,
            ]);
        }
    }
}
