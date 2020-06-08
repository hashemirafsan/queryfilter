<?php


namespace Hashemi\QueryFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class QueryFilter
 * @package Hashemi\QueryFilter
 */
class QueryFilter
{
    /**
     * @var
     */
    protected $request;

    /**
     * @var
     */
    protected $builder;

    public function __construct(Request $request, Builder $builder)
    {
        $this->setRequest($request);
        $this->setBuilder($builder);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder) : Builder
    {
        $this->setBuilder($builder);

        $params = $this->getRequest()->all();
        foreach ($params as $method => $param) {
            $method = sprintf('%sFilter', ucwords($method, '_'));
            if (method_exists($this, $method)) {
                call_user_func_array([$this, $method], [$param]);
            }
        }

        return $this->getBuilder();
    }

    /**
     * @param Request $request
     */
    protected function setRequest(Request $request) : void
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    protected function getRequest() : Request
    {
        return $this->request;
    }

    /**
     * @param mixed $builder
     */
    public function setBuilder($builder): void
    {
        $this->builder = $builder;
    }

    /**
     * @return Builder
     */
    public function getBuilder() : Builder
    {
        return $this->builder;
    }
}