<?php

namespace App\Nova\Resources;

use App\Nova\Actions\ProductDiscontinued;
use App\Nova\Resource;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaMediaHub\Nova\Fields\MediaHubField;
use App\Nova\Filters\ProductPublishedType;
use App\Nova\Filters\ProductCampaignType;
use App\Nova\Filters\ProductFrontPageType;
use App\Nova\Metrics\ProductPublished;
use Laravel\Nova\Fields\HasMany;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Product\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'our_art_no',
        'manufacture_art_no',
        'ean',
        'isbn',
        'slug',
        'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable()->hideFromIndex()->hideWhenUpdating()->hideWhenCreating(),
            Boolean::make('Publicerad','published')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->published ?? true])
                ->hideFromIndex(),

            Text::make('Namn', 'name')
                ->sortable()
                ->rules('required','max:255')
                ->hideFromDetail()
                ->hideFromIndex(),

            Text::make('Tillverkarens artikelnummer', 'manufacture_art_no')
                ->sortable()
                ->rules('max:255')
                ->hideFromIndex(),

            Text::make('Artikelnummer', 'our_art_no')
                ->sortable()
                ->rules('required','max:255'),

            Text::make(__('BB SKU'), 'bb_sku')
                ->readonly()
                ->hideWhenCreating()
                ->hideFromIndex(),

            Text::make(__('Despec SKU'), 'despec_sku')
                ->readonly()
                ->hideWhenCreating()
                ->hideFromIndex(),

            Boolean::make('Visas på startsidan', 'show_on_start_page')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->show_on_start_page ?? false])
                ->hideFromIndex()
                ->hideWhenCreating(),

            Number::make('Marginal mål','margin_target')
                ->rules('required'),

            Number::make('Produktens visningsvikt','target_page'),

            Boolean::make('Kampanj', 'campaign_product')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->campaign_product ?? false])
                ->hideFromIndex()
                ->hideWhenCreating(),

            Select::make('Märke', 'brand_id')
                ->sortable()
                ->options($this->getBrandOptions())
                ->displayUsingLabels()
                ->showOnPreview()
                ->rules('required'),

            Select::make('Kategori', 'category_id')
                ->sortable()
                ->options($this->getCategoryOptions())
                ->displayUsingLabels()
                ->showOnPreview()
                ->rules('required'),

            Text::make('ENA', 'ean')
                ->hideFromIndex()
                ->rules('required')
                ->sortable(),

            Text::make('ISBN', 'isbn')
                ->hideFromIndex()
                ->sortable()
                ->hideFromIndex(),

            Trix::make('Beskrivning', 'description')
                ->hideFromDetail()
                ->sortable()
                ->rules('required')
                ->hideFromIndex(),

            MediaHubField::make('Media', 'image')
                ->defaultCollection('products')
                ->multiple(), /**/

            Number::make('Lagerantal', 'stock')
                ->sortable()
                ->readonly()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Boolean::make('Rabatteringsbar','discountable')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->discountable ?? true])
                ->hideFromIndex(),

            /*
            Boolean::make('Omvänd moms','vat_reverse')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->vat_reverse ?? true])
                ->hideFromIndex(),/**/

            Select::make('Moms', 'vat_class_se')
                ->sortable()
                ->options($this->getVatClassSeOptions())
                ->displayUsingLabels()
                ->showOnPreview()
                ->rules('required')
                ->hideFromIndex(),

            Number::make('Försäljningspris i ören', 'selling_price')
                ->sortable(),

            /*
            DateTime::make(__('Utgått ur sortimentet'), 'stock_discontinued')
                ->readonly()
                ->hideWhenCreating()
                ->hideFromIndex(),/**/

            Boolean::make('Ingår i sortimentet','stock_discontinued')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->stock_discontinued ?? true])
                ->hideFromIndex(),

            DateTime::make(__('Slut i lager'), 'stock_out')
                ->readonly()
                ->hideWhenCreating()
                ->hideFromIndex(),

            Date::make(__('Inkommande'), 'stock_incoming')
                ->readonly()
                ->hideWhenCreating()
                ->hideFromIndex(),


            DateTime::make(__('Skapad'), 'created_at')
                ->readonly()
                ->hideWhenCreating()
                ->hideFromIndex(),

            DateTime::make(__('Uppdaterad'), 'updated_at')
                ->readonly()
                ->hideWhenCreating()
                ->hideFromIndex(),

            DateTime::make(__('Kastad'), 'deleted_at')
                ->readonly()
                ->hideWhenCreating()
                ->hideFromIndex(),

            HasMany::make('SellingPrice'),
            HasMany::make('PurchasePrice'),
        ];
    }

    public function getVatClassSeOptions()
    {
        return [
            '25_percent' => '25%',
            '12_percent' => '12%',
            '6_percent' => '6%',
        ];
    }

    public function getBrandOptions()
    { //published
        $brand = new \App\Models\Product\Brand();
        $brands = $brand::query()
                ->where('published', '=', 1)
                ->get();
        return $brands->pluck('name', 'id');
    }

    public function getCategoryOptions()
    {
        $category = new \App\Models\Product\Category();
        $categorys = $category::all();
        return $categorys->pluck('name', 'id');
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            new ProductPublished,
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new ProductPublishedType,
            new ProductCampaignType,
            new ProductFrontPageType,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            new ProductDiscontinued,
        ];
    }
}


