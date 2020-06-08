<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, DummyFilter $filter)
    {
        $user = User::filter($filter)->get();
        // do whatever
    }
}