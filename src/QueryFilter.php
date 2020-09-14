<?php

declare(strict_types=1);

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

    /**
     * @var bool
     */
    protected $requestParamsOnly = false;

    /**
     * @var bool
     */
    protected $customQueryParamsOnly = false;


    /**
     * QueryFilter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->setRequest($request);
    }

    /**
     * This method will built the logical portion which is define
     * in your filter file
     *
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder): Builder
    {
        $this->setBuilder($builder);

        $params = $this->getFilterParams();
        foreach ($params as $method => $param) {
            $method = sprintf('apply%sProperty', Str::studly($method));
            if (method_exists($this, $method)) {
                call_user_func_array([$this, $method], [$param, $params]);
            }
        }

        return $this->getBuilder();
    }

    /**
     * This method will set Request
     *
     * @param Request $request
     */
    protected function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * This method will set this filter serve for only
     * Request params or not
     *
     * @param bool $requestParamsOnly
     */
    public function setRequestParamsOnly(bool $requestParamsOnly): self
    {
        $this->requestParamsOnly = $requestParamsOnly;

        return $this;
    }

    /**
     * When you want to execute only request params only then
     * you should made it "true" otherwise default it's "false"
     *
     * @return bool
     */
    protected function isRequestParamsOnly(): bool
    {
        return $this->requestParamsOnly;
    }

    /**
     * This method will set this filter serve for only
     * Custom params or not
     *
     * @param bool $customQueryParamsOnly
     */
    public function setCustomQueryParamsOnly(bool $customQueryParamsOnly): self
    {
        $this->customQueryParamsOnly = $customQueryParamsOnly;

        return $this;
    }

    /**
     * When you want to execute only custom params only then
     * you should made it "true" otherwise default it's "false"
     *
     * @return bool
     */
    public function isCustomQueryParamsOnly(): bool
    {
        return $this->customQueryParamsOnly;
    }

    /**
     * This method will provide "Request" instance
     *
     * @return Request
     */
    protected function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * This method will set "Builder"
     *
     * @param mixed $builder
     */
    public function setBuilder($builder): void
    {
        $this->builder = $builder;
    }

    /**
     * This method will provide "Builder" instance
     *
     * @return Builder
     */
    public function getBuilder(): Builder
    {
        return $this->builder;
    }

    /**
     * This method will set queries
     *
     * @param array $queries
     * @return $this
     */
    public function setQueries (array $queries): self
    {
        $this->queries = $queries;

        return $this;
    }

    /**
     * This method will provide queries
     *
     * @return array
     */
    public function getQueries(): array
    {
        return $this->queries;
    }

    /**
     * This method will provide Filter params
     *
     * @return array
     */
    private function getFilterParams(): array
    {
        if ($this->isRequestParamsOnly()) {
            return $this->getRequest()->all();
        }

        if ($this->isCustomQueryParamsOnly()) {
            return $this->getQueries();
        }

        return array_merge($this->getRequest()->all(), $this->getQueries());
    }
}