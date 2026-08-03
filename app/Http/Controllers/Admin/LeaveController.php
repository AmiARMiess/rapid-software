<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeaveController extends Controller
{
    public function showLeave(): View
    {
        return view('admin.leave');
    }

    public function showCreateLeave(): View
    {
        return view('admin.leave_create');
    }
}
