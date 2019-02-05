<?php

namespace App\Http\Controllers\Api;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\Project as ProjectResource;

class ProjectsApiController extends Controller
{
    public function index()
    {
        $projects = QueryBuilder::for(Project::class)
                        ->get();

        return ProjectResource::collection($projects);
    }
}
