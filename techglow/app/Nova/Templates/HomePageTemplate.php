<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Outl1ne\PageManager\Template;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Trix;

class HomePageTemplate extends Template
{
    public static $seo = true;
    public static $view = 'page.page-simple';

    // Name displayed in CMS
    public function name(Request $request): string
    {
        return parent::name($request);
    }

    public function fields(Request $request): array
    {
        return [
            Text::make('legend'),
            Text::make('Title'),
            Trix::make('Content'),
            Heading::make('<p class="text-start">Guides section</p>')
                ->asHtml(),
        ];
    }

    // Resolve data for serialization
    public function resolve($page, $params): array
    {
        // Modify data as you please (ie turn ID-s into models)
        return $page->data ?? [];
    }

    // Optional suffix to the route (ie {blogPostName})
    public function pathSuffix(): string|null
    {
        return null;
    }
}
