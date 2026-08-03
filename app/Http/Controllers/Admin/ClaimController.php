<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClaimController extends Controller
{
    public function showClaim(): View
    {
        return view('admin.claims');
    }

    public function showCreateClaim(): View
    {
        return view('admin.claim_create');
    }
}
