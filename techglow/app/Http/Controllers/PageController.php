<?php

namespace App\Http\Controllers;

use App\Models\PageTranslations;
use App\Http\Requests\StorePageContentsRequest;
use App\Http\Requests\UpdatePageContentsRequest;
use Illuminate\Http\Request;
use Outl1ne\PageManager\Helpers\NPMHelpers;
use Outl1ne\PageManager\NPM;
use Outl1ne\PageManager\Models\Page;

class PageController extends Controller
{



    public function show(Request $request, string $slug)
    {
        $locale = app()->getLocale();
        $model = NPM::getPageModel();
        $jsonPath = 'slug->' . $locale;
        $page = $model::select()->whereJsonContains($jsonPath, $slug)->firstOrFail();


        //$page = Page::where('slug', $slug)->first();
        if (empty($page)) {
            abort(404);
        }
        /**
         * @var Page $page
         * /
        if (!$page->isPublished()) {
            $token = (string)$request->get('previewToken', '');
            if ($token !== $page->preview_token) {
                abort(403);
            }
        }

        return sprintf('PAGE %d', $page->id);
/**/
    }
}
