<?php

namespace App\Nova\Resources;

use App\Nova\Actions\CancellingOrder;
use App\Nova\Resource;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaMediaHub\Nova\Fields\MediaHubField;
use Illuminate\Http\Request;
use App\Nova\Metrics\NewOrders;
use Laravel\Nova\Fields\ID;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Order>
     */
    public static $model = \App\Models\Order\Order::class;

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
        /**
        'id' => 'integer',
        'order_status' => 'string',
        'payment_status' => 'string',
        'fortnox_no' => 'string',
        'pin' => 'string',
        'credited' => 'boolean',
        'credited_by' => 'string',
        'credited_at' => 'datetime',
        'customer_id' => 'integer',
        'user_id' => 'integer',
        'payment_provider_id' => 'integer',
        'payment_provider_ref' => 'string',
        'sellorder_number' => 'string',
        'send_invoice' => 'string',
        'cancelled' => 'boolean',
        'cancelled_at' => 'datetime',
        'your_reference' => 'string',
        'our_reference' => 'string',
        'subtotal' => 'integer',
        'discount' => 'integer',
        'vat' => 'integer',
        'vat_is_moms' => 'boolean',
        'equalization' => 'integer',
        'shipping' => 'integer',
        'total' => 'integer',
        'paid' => 'integer',
        'paid_at' => 'datetime',
        'currency' => 'string',
        'payment_terms' => 'string',
        'mode_of_delivery' => 'string',
        'comment' => 'string',
        'accounting_at' => 'datetime',

         */
        return [
            ID::make()->sortable()->hideFromIndex()->hideWhenUpdating()->hideWhenCreating(),

            Text::make('Order Status', 'order_status')
                ->readonly()
                ->sortable(),

            Text::make('Payment Status', 'payment_status')
                ->readonly()
                ->sortable(),

            Boolean::make('Credited','credited')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->credited ?? false])
                ->hideFromIndex()
                ->readonly(),


            Boolean::make('Cancelled','cancelled')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->cancelled ?? false])
                ->hideFromIndex()
                ->readonly(),

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
        return [
            new NewOrders,
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
        return [
            new CancellingOrder,
        ];
    }
}
