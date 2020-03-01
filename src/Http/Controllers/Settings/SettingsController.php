<?php


namespace Tessify\Core\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function getSettings()
    {
        return view("tessify-core::pages.settings.overview", []);
    }
}