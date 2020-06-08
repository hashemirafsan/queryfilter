<?php


class UserFilter extends \Hashemi\QueryFilter\QueryFilter
{
    public function nameFilter($value)
    {
        return $this->builder->where('name', '=', $value);
    }
}