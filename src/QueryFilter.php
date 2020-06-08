<?php


namespace Hashemi\QueryFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class QueryFilter
 * @package Hashemi\QueryFilter
 */
class QueryFilter
{
    /**
     * @var
     */
    private $request;

    /**
     * @var
     */
    protected $builder;

    /**
     * @var array
     */
    protected $queries = [];

    public function __construct(Request $request)
    {
        $this->setRequest($request);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder) : Builder
    {
        $this->setBuilder($builder);

        $params = $this->getFilterParams();
        foreach ($params as $method => $param) {
            $method = sprintf('apply%sProperty', Str::studly($method));
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

    /**
     * @param array $queries
     *
     * @return $this
     */
    public function setQueries (array $queries) : self
    {
        $this->queries = $queries;

        return $this;
    }

    /**
     * @return array
     */
    public function getQueries () : array
    {
        return $this->queries;
    }

    /**
     * @return array
     */
    private function getFilterParams () : array
    {
        return array_merge($this->getRequest()->all(), $this->getQueries());
    }
}