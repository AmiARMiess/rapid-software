<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function showAttendance(): View
    {
        return view('admin.attendance');
    }

    public function showCreateAttendance(): View
    {
        return view('admin.attendance_create');
    }
}
