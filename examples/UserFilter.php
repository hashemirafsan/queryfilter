<?php


class UserFilter extends \Hashemi\QueryFilter\QueryFilter
{
    public function applyNameFilter($value)
    {
        return $this->builder->where('name', '=', $value);
    }
}