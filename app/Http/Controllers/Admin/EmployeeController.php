<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function showEmployee(): View
    {
        return view('admin.employee');
    }

    public function showCreateEmployee(): View
    {
        return view('admin.employee_create');
    }

}
