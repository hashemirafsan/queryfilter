<?php

namespace Hashemi\QueryFilter;

use Illuminate\Support\ServiceProvider;

class QueryFilterServiceProvider extends ServiceProvider
{
    public function register () {
        if ($this->app->runningInConsole()) {
            $this->commands([ QueryFilterGenerateCommand::class ]);
        }
    }

    public function provides () {
        return [];
    }
}