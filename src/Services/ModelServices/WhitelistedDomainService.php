<?php

namespace Tessify\Core\Services\ModelServices;

use Tessify\Core\Models\WhitelistedDomain;
use Tessify\Core\Traits\ModelServiceGetters;
use Tessify\Core\Contracts\ModelServiceContract;

class WhitelistedDomainService implements ModelServiceContract
{
    use ModelServiceGetters;

    private $model;
    private $records;
    private $preloadedRecords;

    public function __construct()
    {
        $this->model = "Tessify\Core\Models\WhitelistedDomain";
    }
    
    public function preload($instance)
    {
        return $instance;
    }

    public function getAllDomains()
    {
        $out = [];

        foreach ($this->getAll() as $whitelistedDomain)
        {
            $out[] = $whitelistedDomain->domain;
        }

        return $out;
    }

    public function emailIsWhitelisted($email)
    {
        // Grab all of the whitelisted domains
        $domains = $this->getAllDomains();

        // Explode the email by it's @ symbol; everything behind the @ is considered the domain
        $parts = explode("@", $email);
        if (count($parts) > 1)
        {
            $domain = $parts[1];
            return in_array($domain, $domains);
        }

        // Return false by default (in case the email couldn't be exploded due to being invalid)
        return false;
    }

    public function saveFromRequest($encodedDomains)
    {
        WhitelistedDomain::query()->delete();

        $domains = json_decode($encodedDomains);
        if (is_array($domains) && count($domains))
        {
            foreach ($domains as $domain)
            {
                WhitelistedDomain::create([
                    "domain" => $domain
                ]);
            }
        }
    }
}