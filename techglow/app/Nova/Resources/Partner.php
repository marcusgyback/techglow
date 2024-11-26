<?php

namespace App\Nova\Resources;

use App\Nova\Resource;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaMediaHub\Nova\Fields\MediaHubField;

class Partner extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Partner>
     */
    public static $model = \App\Models\Partner\Partner::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = ['first_name','last_name'];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'first_name',
        'last_name',
        'email',
        'twitch_url',
        'ssn',

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
            MediaHubField::make('Media', 'image')
                ->defaultCollection('partners')
                ->multiple()
                ->hideFromIndex(),

            Boolean::make('Aktiv','active')
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->active ?? true]),

            Select::make('Användarkonto', 'user_id')
                ->options($this->getUserOptions())
                ->displayUsingLabels()
                ->nullable()
                ->showOnPreview(),

            Text::make(__('Partner typ'), 'partner_type')->hideFromIndex(),
            Text::make(__('Partner nivå'), 'partner_level')->hideFromIndex(),
            Text::make(__('Ansökningsdatum'), 'created_at'),
            Text::make(__('Förnamn'), 'first_name'),
            Text::make(__('Efternamn'), 'last_name'),
            Text::make(__('Epost'), 'email')->hideFromIndex(),
            Text::make(__('Mobilnummer'), 'phone')->hideFromIndex(),
            Text::make(__('Address'), 'address')->hideFromIndex(),
            Text::make(__('Personnummer'), 'ssn')->hideFromIndex(),
            Text::make(__('Postnummer'), 'postal_code')->hideFromIndex(),
            Text::make(__('City'), 'city')->hideFromIndex(),
            Text::make(__('Twitch'), 'twitch_url'),
            Text::make(__('Youtube'), 'youtube_url'),
            Text::make(__('Instagram'), 'instagram_url'),
            Text::make(__('Facebook'), 'facebook_url'),

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
