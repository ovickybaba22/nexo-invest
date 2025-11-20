<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanAdminController extends Controller
{
    public function index()
    {
        $plans = Plan::orderBy('id')->get();

        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        // empty Plan instance just so we can reuse the form UI if you want
        $plan = new Plan();

        return view('admin.plans.create', compact('plan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'               => ['required', 'string', 'max:255'],
            'min_deposit'        => ['required', 'numeric', 'min:0'],
            'target_roi_percent' => ['required', 'numeric', 'min:0'],
        ]);

        Plan::create($data);   // make sure Plan has fillable fields for these

        return redirect()
            ->route('admin.plans.index')
            ->with('status', 'Plan created successfully.');
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'name'               => ['required', 'string', 'max:255'],
            'min_deposit'        => ['required', 'numeric', 'min:0'],
            'target_roi_percent' => ['required', 'numeric', 'min:0'],
        ]);

        $plan->update($data);

        return redirect()
            ->route('admin.plans.index')
            ->with('status', 'Plan updated successfully.');
    }
}