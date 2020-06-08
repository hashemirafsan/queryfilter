<?php


class UserController extends \App\Http\Controllers\Controller
{
    public function index(\Illuminate\Http\Request $request, UserFilter $filter)
    {
        $user = User::query()->apply_filter($filter)->get();
        // do whatever
    }
}