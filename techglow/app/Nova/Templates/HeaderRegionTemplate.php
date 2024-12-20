<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Outl1ne\PageManager\Template;

class HeaderRegionTemplate extends Template
{
    // Name displayed in CMS
    public function name(Request $request): string
    {
        return parent::name($request);
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [];
    }

    // Resolve data for serialization
    public function resolve($region, $params): array
    {
        // Modify data as you please (ie turn ID-s into models)
        return $region->data ?? [];
    }
}
