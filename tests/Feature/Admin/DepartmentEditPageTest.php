<?php

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

it('renders the department edit page with the expected design fields', function () {
    if (! Schema::hasTable('departments')) {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    $user = User::factory()->create(['role' => 'admin']);

    $department = Department::query()->forceCreate([
        'user_id' => $user->id,
        'name' => 'Engineering',
        'description' => 'Build and maintain product systems.',
    ]);

    $response = $this->actingAs($user)
        ->get(route('admin.edit.department', ['department_id' => $department->id]));

    $response->assertStatus(200)
        ->assertSee('Edit Department')
        ->assertSee('Department Details')
        ->assertSee('Department Name');
});
