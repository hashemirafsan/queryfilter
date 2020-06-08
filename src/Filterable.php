<?php


namespace Hashemi\QueryFilter;


use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Filterable
 * @package Hashemi\QueryFilter
 */
trait Filterable
{
    /**
     * @param Builder $builder
     * @param QueryFilter $filter
     * @return Builder
     */
    public static function scopeFilter(Builder $builder, QueryFilter $filter) : Builder
    {
        return $filter->apply($builder);
    }
}