<?php

namespace App\Nova\Resources;

use Illuminate\Http\Request;
use App\Nova\Resource;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasOne;
use App\Nova\Filters\ProductSellingPriceFilter;

class SellingPrice extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\AppModelsProductSellingPrice>
     */
    public static $model = \App\Models\Product\SellingPrice::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

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
            Number::make('Säljpris', 'price')
                ->sortable()
                ->displayUsing(function($amount){
                    return number_format((float) $amount/100, 2, ",", " ");
                })
                ->rules('required'),

            Select::make('Valuta', 'currency')
                ->sortable()
                ->options($this->getCurrencyOptions())
                ->displayUsingLabels()
                ->showOnPreview()
                ->rules('required'),

            DateTime::make(__('Giltig från'), 'valid_from'),
            DateTime::make(__('Giltig till'), 'valid_to'),

            Boolean::make('Realisation','realisation')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->discountable ?? false]),

            Boolean::make('Kampanj', 'campaign')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->campaign ?? false]),

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
        return [
            new ProductSellingPriceFilter,
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
        return [];
    }
}
