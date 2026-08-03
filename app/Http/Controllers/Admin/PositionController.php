<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Position;
use App\Models\OptionStatus;
use App\Models\OptionLevel;

class PositionController extends Controller
{
    public function showPosition(): View
    {
        return view('admin.position');
    }

    public function showCreatePosition(): View
    {
        $departments = Department::where('user_id', auth()->user()->id)->get();
        $positions = Position::where('user_id', auth()->user()->id)->get();
        $optionStatuses = OptionStatus::all();
        $optionLevels = OptionLevel::all();

        return view('admin.position_create', compact('departments', 'positions', 'optionStatuses', 'optionLevels'));
    }

    public function showEditPosition(Request $request): View
    {
        $departments = Department::where('user_id', auth()->user()->id)->get();
        $position = Position::where('id', $request->position_id)->where('user_id', auth()->user()->id)->firstOrFail();
        $positions = Position::where('user_id', auth()->user()->id)->get();
        $optionStatuses = OptionStatus::all();
        $optionLevels = OptionLevel::all();

        return view('admin.position_edit', compact('departments', 'position', 'positions', 'optionStatuses', 'optionLevels'));
    }

    public function positionDatatable(Request $request)
    {
        $query = Position::query()->where('user_id', auth()->user()->id);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
                // ->orWhereHas('optionGender', function ($optionGenderQuery) use ($search) {
                //     $optionGenderQuery->where('gender', 'like', "%{$search}%");
                // });
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

    public function showViewPosition(Request $request): View
    {
        $countTotalPosition = Employee::where('position', $request->position_id)->where('user_id', auth()->user()->id)->count();

        return view('admin.position_view', compact('countTotalPosition'));
    }
}
