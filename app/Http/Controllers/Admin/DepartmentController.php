<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function showDepartment(): View
    {
        return view('admin.department');
    }

    public function showCreateDepartment(): View
    {
        return view('admin.department_create');
    }

    public function departmentDatatable(Request $request)
    {
        $query = Department::query()->where('user_id', auth()->user()->id);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $sortBy = json_decode($request->get('sortBy', '[]'), true);

        if (is_array($sortBy) && ! empty($sortBy)) {
            $sort = $sortBy[0];

            if (isset($sort['key']) && isset($sort['order'])) {
                $query->orderBy($sort['key'], $sort['order'] === 'desc' ? 'desc' : 'asc');
            }
        }

        $page = (int) $request->get('page', 1);
        $itemsPerPage = (int) $request->get('itemsPerPage', 5);

        $total = $query->count();

        $items = $query
            ->skip(($page - 1) * $itemsPerPage)
            ->take($itemsPerPage)
            ->get()
            ->values();

        return response()->json([
            'items' => $items,
            'total' => $total,
        ]);
    }
}
