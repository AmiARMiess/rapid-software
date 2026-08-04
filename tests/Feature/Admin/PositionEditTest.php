<?php

use App\Models\OptionLevel;
use App\Models\OptionStatus;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

it('updates a position through the admin edit route and persists the posted form data', function () {
    if (! Schema::hasTable('positions')) {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('name');
            $table->unsignedBigInteger('department')->nullable();
            $table->unsignedBigInteger('reporting_to')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->unsignedBigInteger('level')->nullable();
            $table->timestamps();
        });
    }

    if (! Schema::hasTable('departments')) {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('name');
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

    if (! Schema::hasTable('option_levels')) {
        Schema::create('option_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    OptionStatus::query()->create(['name' => 'Active']);
    OptionLevel::query()->create(['name' => 'Senior']);

    $user = User::factory()->create(['role' => 'admin']);

    $position = Position::create([
        'user_id' => $user->id,
        'name' => 'Junior Developer',
        'department' => null,
        'reporting_to' => null,
        'description' => null,
        'status' => null,
        'level' => null,
    ]);

    $response = $this->actingAs($user)
        ->post(route('admin.update.position', ['position_id' => $position->id]), [
            'name' => 'Senior Developer',
            'department' => null,
            'reporting_to' => null,
            'description' => 'Owns the core platform work.',
            'status' => 1,
            'level' => 1,
            'responsibilities' => ['Code review', 'Mentoring'],
        ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('positions', [
        'id' => $position->id,
        'name' => 'Senior Developer',
        'description' => 'Owns the core platform work.',
        'status' => 1,
        'level' => 1,
    ]);
});
