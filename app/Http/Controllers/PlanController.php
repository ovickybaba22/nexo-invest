<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::where('is_active', true)
            ->orderBy('min_deposit')
            ->get();

        return view('plans.index', compact('plans'));
    }

    public function show(Plan $plan)
    {
        // Make sure the plan is active
        abort_unless($plan->is_active, 404);

        // Instead of loading a missing "plans.show" view,
        // redirect straight to the investment form page
        return redirect()->route('invest.start', $plan);
    }
}
