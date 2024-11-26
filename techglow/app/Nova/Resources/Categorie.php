<?php

namespace App\Nova\Resources;

use App\Nova\Resource;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\PageManager\NPM;

class Categorie extends Resource
{

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Product\Category::class;

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
            Text::make('Namn', 'name')
                ->sortable()
                ->rules('max:200')
                ->rules('required','max:255'),

            Select::make('Överordnad', 'parent_id')
                ->options($this->getParentOptions())
                ->displayUsingLabels()
                ->nullable()
                ->showOnPreview(),

            Textarea::make('Beskrivning', 'description')
                ->sortable()
                ->rules('max:2048')
                ->hideFromDetail(),

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

    public function getParentOptions()
    {
        $category = new \App\Models\Product\Category();
        if ($this->resource?->id) {
            $categorys = $category::query()
                ->where('id', '<>', $this->id)
                ->where(fn ($query) => $query
                    ->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $this->id))
                ->get();
        } else {
            $categorys = $category::all();
        }
        return $categorys->pluck('name', 'id');
    }

    public function title()
    {
        return "{$this->name} ({$this->slug})";
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
