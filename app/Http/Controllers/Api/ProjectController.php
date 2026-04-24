<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with(['category', 'media'])
            ->where('is_published', true)
            ->when($request->category, fn($q) => $q->whereHas('category', fn($q) => $q->where('slug', $request->category)))
            ->orderBy('sort_order')
            ->paginate(12);

        return response()->json($projects);
    }

    public function show(string $slug)
    {
        $project = Project::with(['category', 'media'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return response()->json($project);
    }
}
