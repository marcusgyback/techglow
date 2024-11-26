<?php

namespace App\Nova\Resources;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;


class PurchasePrice extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\PurchasePrice>
     */
    public static $model = \App\Models\Product\PurchasePrice::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'price';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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

            Number::make('Inköpspris', 'price')
                ->sortable()
                ->rules('required'),

            Select::make('Valuta', 'currency')
                ->sortable()
                ->options($this->getCurrencyOptions())
                ->displayUsingLabels()
                ->showOnPreview()
                ->rules('required'),

            Number::make('Normal Pris', 'price_retail')
                ->sortable()
                ->rules('required')
                ->hideFromIndex(),

            Number::make('Föreslaget pris', 'price_in_shops')
                ->sortable()
                ->rules('required')
                ->hideFromIndex(),

            DateTime::make(__('Giltig från'), 'valid_from')->sortable(),
            DateTime::make(__('Giltig till'), 'valid_to')->sortable(),

            Boolean::make('Realisation','realisation')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->discountable ?? false]),

            Boolean::make('Kampanj', 'campaign_product')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->campaign ?? false]),

            Text::make('Artikelnummer', 'article_number')
                ->sortable()
                ->rules('required','max:255')
                ->hideFromIndex(),

            Boolean::make('Utgått ur sortimentet', 'stock_discontinued')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->stock_out ?? false])
                ->hideFromIndex(),

            Boolean::make('Slut i lager', 'stock_out')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->stock_out ?? false])
                ->hideFromIndex(),

            DateTime::make(__('Nästa leverans'), 'stock_incoming')
                ->readonly()
                ->hideWhenCreating()
                ->hideFromIndex(),


            Text::make('Intrastat', 'intrastat')
                ->sortable()
                ->hideWhenUpdating()
                ->hideFromIndex(),

            DateTime::make(__('Skapad'), 'created_at')
                ->readonly()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->hideFromIndex(),

            DateTime::make(__('Uppdaterad'), 'updated_at')
                ->readonly()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->hideFromIndex(),

            DateTime::make(__('Kastad'), 'deleted_at')
                ->readonly()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->hideFromIndex(),

            HasOne::make('Product')->readonly(),
            HasOne::make('Supplier')->readonly(),
        ];
    }

    public function getCurrencyOptions()
    {
        return [
            'SEK' => 'SEK',
            'EUR' => 'EUR',
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
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
        return [];
    }
}
