<?php

use Hashemi\QueryFilter\QueryFilter;

class UserFilter extends QueryFilter
{
    public function applyNameFilter ($value) {
        return $this->builder->where('name', '=', $value);
    }
}