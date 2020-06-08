<?php


namespace Hashemi\QueryFilter;


use Illuminate\Database\Query\Builder;

/**
 * Trait Filterable
 * @package Hashemi\QueryFilter
 */
trait Filterable
{
    /**
     * @param $builder
     * @param QueryFilter $filter
     * @return Builder
     */
    public static function scopeApplyFilter($builder, QueryFilter $filter) : Builder
    {
        return $filter->apply($builder);
    }
}