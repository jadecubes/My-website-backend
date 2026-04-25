<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NavLink;

class NavController extends Controller
{
    public function index()
    {
        return response()->json(
            NavLink::where('is_published', true)
                ->orderBy('sort_order')
                ->get()
        );
    }
}
