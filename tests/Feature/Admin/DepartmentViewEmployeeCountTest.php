<?php

use App\Models\Department;
use App\Models\Employee;
use App\Models\OptionStatus;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

it('counts employees whose positions belong to the department', function () {
    if (! Schema::hasTable('departments')) {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('name');
            $table->unsignedBigInteger('status')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    if (! Schema::hasTable('positions')) {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('name');
            $table->unsignedBigInteger('department')->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->unsignedBigInteger('level')->nullable();
            $table->unsignedBigInteger('reporting_to')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    if (! Schema::hasTable('option_statuses')) {
        Schema::create('option_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    if (! Schema::hasTable('department_responsibles')) {
        Schema::create('department_responsibles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->string('name');
            $table->timestamps();
        });
    }

    if (! Schema::hasTable('employees')) {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('full_name');
            $table->string('employee_number');
            $table->unsignedBigInteger('position');
            $table->unsignedBigInteger('gender')->nullable();
            $table->timestamps();
        });
    }

    $user = User::factory()->create(['role' => 'admin']);

    $department = Department::query()->forceCreate([
        'user_id' => $user->id,
        'name' => 'Engineering',
        'status' => null,
        'description' => 'Testing department employee count.',
    ]);

    $position = Position::query()->forceCreate([
        'user_id' => $user->id,
        'name' => 'Developer',
        'department' => $department->id,
        'status' => null,
        'level' => null,
        'reporting_to' => null,
        'description' => null,
    ]);

    Employee::query()->forceCreate([
        'user_id' => $user->id,
        'full_name' => 'Test Employee',
        'employee_number' => 'EMP001',
        'position' => $position->id,
        'gender' => null,
    ]);

    $otherUser = User::factory()->create(['role' => 'admin']);
    Employee::query()->forceCreate([
        'user_id' => $otherUser->id,
        'full_name' => 'Other User Employee',
        'employee_number' => 'EMP002',
        'position' => $position->id,
        'gender' => null,
    ]);

    $response = $this->actingAs($user)
        ->get(route('admin.view.department', ['department_id' => $department->id]));

    $response->assertStatus(200);
    $response->assertSee('Total Employee');
    $response->assertSee('1');
});
