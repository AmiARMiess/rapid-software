<?php

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

it('saves responsibilities through the position relation', function () {
    Schema::create('positions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('name');
        $table->integer('department')->nullable();
        $table->integer('reporting_to')->nullable();
        $table->text('description')->nullable();
        $table->integer('status')->nullable();
        $table->integer('level')->nullable();
        $table->timestamps();
    });

    Schema::create('position_responsibles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('position_id')->constrained()->cascadeOnDelete();
        $table->string('name');
    });

    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $position = Position::create([
        'user_id' => $user->id,
        'name' => 'Software Engineer',
    ]);

    $this->actingAs($user)
        ->post(route('admin.update.position', ['position_id' => $position->id]), [
            'name' => 'Software Engineer',
            'department' => null,
            'reporting_to' => null,
            'description' => null,
            'status' => null,
            'level' => null,
            'responsibilities' => ['Write code', 'Review PRs'],
        ])
        ->assertRedirect();

    expect($position->refresh()->positionResponsibles()->pluck('name')->all())
        ->toBe(['Write code', 'Review PRs']);
});
