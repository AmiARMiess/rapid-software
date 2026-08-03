<?php

use App\Models\Employee;
use App\Models\User;

it('returns employee datatable json using the real database query', function () {
    $user = User::factory()->create(['role' => 'admin']);

    Employee::create([
        'full_name' => 'Alice Johnson',
        'gender' => 1,
    ]);

    Employee::create([
        'full_name' => 'Bob Smith',
        'gender' => 2,
    ]);

    $response = $this
        ->actingAs($user)
        ->getJson(route('admin.datatable.employee', [
            'page' => 1,
            'itemsPerPage' => 5,
            'search' => 'Alice',
            'sortBy' => '[]',
        ]));

    $response
        ->assertOk()
        ->assertJsonPath('total', 1)
        ->assertJsonCount(1, 'items')
        ->assertJsonPath('items.0.full_name', 'Alice Johnson')
        ->assertJsonPath('items.0.gender', 1)
        ->assertJsonPath('items.0.gender_id', 1);
});
