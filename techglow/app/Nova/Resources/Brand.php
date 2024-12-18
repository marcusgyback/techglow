<?php

namespace App\Nova\Resources;

use App\Nova\Resource;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\DateTime;
use Outl1ne\NovaMediaHub\Nova\Fields\MediaHubField;

class Brand extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Product\Brand::class;

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
        'name'
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
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->published ?? true]),

            MediaHubField::make('Media', 'image')
                ->defaultCollection('brand')
                ->multiple(),

            Text::make(__('Namn'), 'name')
                ->sortable()
                ->rules('required','max:200'),

            DateTime::make(__('Skapad'), 'created_at')
                ->readonly()
                ->hideWhenCreating(),

            DateTime::make(__('Uppdaterad'), 'updated_at')
                ->readonly()
                ->hideWhenCreating(),

            DateTime::make(__('Kastad'), 'deleted_at')
                ->readonly()
                ->hideWhenCreating()
                ->hideFromIndex(),
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
