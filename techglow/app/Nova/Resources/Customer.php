<?php

namespace App\Nova\Resources;

use App\Nova\Resource;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaMediaHub\Nova\Fields\MediaHubField;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use App\Nova\Metrics\NewCustomer;


class Customer extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Customer>
     */
    public static $model = \App\Models\Profile\Customer::class;

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

            Select::make('Användarkonto', 'user_id')
                ->options($this->getUserOptions())
                ->displayUsingLabels()
                ->showOnPreview()
                ->rules('required')
                ->creationRules('unique:customers,user_id')
                ->updateRules('unique:customers,user_id,{{resourceId}}'),

            DateTime::make(__('Skapad'), 'created_at')
                ->readonly()
                ->hideWhenCreating(),

            DateTime::make(__('Uppdaterad'), 'updated_at')
                ->readonly()
                ->hideWhenCreating(),
        ];
    }

    public function getUserOptions()
    {
        $user = new \App\Models\User();
        if ($this->resource?->user_id) {
            $users = $user::query()
                ->where('id', '=', $this->user_id)
                ->get();
        } else {
            $users = $user::query()
                ->where('email', '=', $this->email)
                ->get();
        }

        $users = $user::all();


        $return = [];

        foreach ($users as $user)
        {
            $return[$user->id] = $user->name . " (" . $user->email . ")";
        }
        return $return;
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
            new NewCustomer,
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
