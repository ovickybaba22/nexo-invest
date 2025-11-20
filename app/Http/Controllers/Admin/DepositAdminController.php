<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;

class DepositAdminController extends Controller
{
    /**
     * Show all deposits for the admin panel.
     */
    public function index()
    {
        $deposits = Deposit::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.deposits.index', compact('deposits'));
    }
}