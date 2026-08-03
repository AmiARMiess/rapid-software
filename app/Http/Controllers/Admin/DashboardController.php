<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function showDashboard(): View
    {
        // dd(User::find(1)->gender()->first()?->gender);

        return view('admin.dashboard');
    }
}
