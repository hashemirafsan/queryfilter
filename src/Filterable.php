<?php

declare(strict_types=1);

namespace Hashemi\QueryFilter;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Filterable
 * @package Hashemi\QueryFilter
 */
trait Filterable
{
    /**
     * This method will be add a scope in your model
     * and apply all the filter you added on your filter file
     *
     * @param Builder $builder
     * @param QueryFilter $filter
     * @param array $customQueryParams
     * @param bool $requestParamsOnly
     * @param bool $customQueryParamsOnly
     * @return Builder
     */
    public static function scopeFilter(
        Builder $builder,
        QueryFilter $filter,
        array $customQueryParams = [],
        bool $requestParamsOnly = false,
        bool $customQueryParamsOnly = false
    ): Builder
    {
        return $filter->setQueries($customQueryParams)
                      ->setRequestParamsOnly($requestParamsOnly)
                      ->setCustomQueryParamsOnly($customQueryParamsOnly)
                      ->apply($builder);
    }
}