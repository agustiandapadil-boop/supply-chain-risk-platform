<?php

namespace App\Http\Controllers;

class AnalyticsViewController extends Controller
{
    public function index()
    {
        return view(
            'analytics.index'
        );
    }
}