<?php

use Hashemi\QueryFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Dummy extends Model
{
    use Filterable;
    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];
}
