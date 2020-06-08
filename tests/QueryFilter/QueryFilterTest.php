<?php

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Loguzz\Formatter\ExceptionArrayFormatter;
use PHPUnit\Framework\TestCase;

class QueryFilterTest extends TestCase
{
    private $filter = null;

    public function setUp () : void {
        $this->filter = new DummyFilter(new Request());
    }

    public function testWithoutFilter () {
        $row = Dummy::first();
        $this->assertTrue($row->id == 1);
    }

    public function testWithNothingToFilter () {
        $row = Dummy::filter($this->filter)->first();
        $this->assertTrue($row->id == 1);
    }

    public function testEmptyFilterReturnsAllData () {
        $rows = Dummy::filter($this->filter)->get();
        $this->assertTrue($rows->count() == 10);
    }

    public function testFilterOnlyId () {
        $request = (new Request())->merge([ 'id' => 2 ]);
        $row = Dummy::filter(new DummyFilter($request))->first();
        $this->assertTrue($row->id == 2);
    }

    public function testFilterWithExtraParams () {
        $row = Dummy::filter($this->filter, [ 'id' => 4 ])->first();
        $this->assertTrue($row->id == 4);
    }

    public function testFilterCheckForCustomField () {
        $rows = Dummy::filter($this->filter, [ 'last_name_like' => 'admin' ])->get();
        $this->assertTrue($rows->count() == 10);
    }
}