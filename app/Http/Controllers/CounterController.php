<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CounterController extends Controller
{
    /**
     * Display the counter.
     */
    public function index()
    {
        $counter = Counter::firstOrCreate([], ['count' => 0]);
        
        return Inertia::render('Counter', [
            'count' => $counter->count
        ]);
    }
    
    /**
     * Increment the counter.
     */
    public function store(Request $request)
    {
        $action = $request->input('action', 'increment');
        $counter = Counter::firstOrCreate([], ['count' => 0]);
        
        if ($action === 'increment') {
            $counter->increment('count');
        } elseif ($action === 'decrement') {
            $counter->decrement('count');
        }
        
        return Inertia::render('Counter', [
            'count' => $counter->count
        ]);
    }
}