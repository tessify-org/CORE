<?php

namespace Tessify\Core\Http\Controllers\Admin;

use Setting;
use WhitelistedDomains;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Admin\Settings\UpdateAuthSettingsRequest;

class SettingsController extends Controller
{
    public function getOverview()
    {
        return view("tessify-core::pages.admin.settings.overview");
    }

    public function getAuthSettings()
    {
        $emailActivationRequired = false;
        if (Setting::has("email_activation_required"))
        {
            $emailActivationRequired = Setting::get("email_activation_required") == "true" ? true : false;
        }

        $whitelistedDomainsEnabled = false;
        if (Setting::has("whitelisted_domains_enabled"))
        {
            $whitelistedDomainsEnabled = Setting::get("whitelisted_domains_enabled") == "true" ? true : false;
        }

        return view("tessify-core::pages.admin.settings.auth", [
            "whitelistedDomains" => WhitelistedDomains::getAll(),
            "settings" => collect([
                "email_activation_required" => $emailActivationRequired,
                "whitelisted_domains_enabled" => $whitelistedDomainsEnabled,
            ]),
            "oldInput" => collect([
                "whitelisted_domains" => old("whitelisted_domains"),
                "email_activation_required" => old("email_activation_required"),
                "whitelisted_domains_enabled" => old("whitelisted_domains_enabled"),
            ])
        ]);
    }

    public function postAuthSettings(UpdateAuthSettingsRequest $request)
    {
        // Save the settings
        Setting::set("email_activation_required", $request->email_activation_required);
        Setting::set("whitelisted_domains_enabled", $request->whitelisted_domains_enabled);

        // Save the whitelisted domains
        WhitelistedDomains::saveFromRequest($request->whitelisted_domains);

        // Flash message & redirect back to the auth settings page
        flash(__("tessify-core::admin.settings_auth_saved"))->success();
        return redirect()->route("admin.settings.auth");
    }
}