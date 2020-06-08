<?php

namespace Hashemi\QueryFilter;

use Illuminate\Console\GeneratorCommand;

class QueryFilterGenerateCommand extends GeneratorCommand
{
    protected $name = 'make:filter';

    protected $description = 'Create a query filter class';

    protected $type = 'Filter';

    protected function getStub () {
        return __DIR__ . '/stubs/filter.stub';
    }

    protected function getDefaultNamespace ($rootNamespace) {
        return $rootNamespace . '\Filters';
    }
}