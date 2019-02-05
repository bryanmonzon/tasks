<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\User as UserResource;

class UsersApiController extends Controller
{
    public function index()
    {
        $users = QueryBuilder::for(User::class)
                    ->allowedFilters(Filter::exact('id'))
                    ->get();

        return UserResource::collection($users);
    }
}
