<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class ProductSellingPriceFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';


    /**
     * The displayable name of the filter.
     *
     * @var string
     */
    public $name = 'Prisfilter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        switch ($value) {
            case 'NOW':
                return $query->where(function($query) {
                    $query->where(function($query) {
                        $query->where('valid_from','<=', \DB::raw('NOW()'))->
                        where('valid_to','>', \DB::raw('NOW()'));
                    })->orWhere(function($query) {
                        $query->where('valid_from','<=', \DB::raw('NOW()'))
                            ->WhereNull('valid_to');
                    });
                })->orderByDesc('price');
                break;
            case 'OLD':
                return $query->where(function($query) {
                    $query->where(function($query) {
                        $query->where('valid_to','<=', \DB::raw('NOW()'));
                    });
                })->orderByDesc('price');
                break;
            case 'FUTURE':
                return $query->where(function($query) {
                    $query->where(function($query) {
                        $query->where('valid_to','>', \DB::raw('NOW()'));
                    });
                })->orderByDesc('price');
                break;
            default:
                return $query->orderByDesc('price');
                break;
        }
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return [
            'Aktuella' => 'NOW',
            'Tidigare' => 'OLD',
            'Framtida' => 'FUTURE',
            'Alla' => 'ALL',
        ];
    }

    public function default()
    {
        return 'NOW';
    }
}
