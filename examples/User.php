<?php

/**
 * Dummy Model
 */
class User extends \Illuminate\Database\Eloquent\Model
{
    // Use Filterable Trait
    // ....
    use \Hashemi\QueryFilter\Filterable;
    // ....
}