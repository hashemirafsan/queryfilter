<?php

use Hashemi\QueryFilter\QueryFilter;

class DummyFilter extends QueryFilter
{
    public function applyIdProperty ($id) {
        $this->builder->where('id', $id);
    }

    public function applyNameProperty ($value) {
        $this->builder->where('first_name', $value);
    }

    public function applyFirstNameLikeProperty ($value) {
        $this->builder->where('first_name', 'LIKE', "%$value%");
    }

    public function applyLastNameLikeProperty ($value) {
        $this->builder->where('last_name', 'like', "%$value%");
    }

    public function applyEmailProperty ($value) {
        $this->builder->where('email', '=', $value);
    }
}