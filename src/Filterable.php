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
     * @param Builder     $builder
     * @param QueryFilter $filter
     * @param array       $queries
     *
     * @return Builder
     */
    public static function scopeFilter(Builder $builder, QueryFilter $filter, array $queries = []) : Builder
    {
        return $filter->setQueries($queries)->apply($builder);
    }
}