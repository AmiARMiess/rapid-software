<?php

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

it('deletes a position through the admin delete route', function () {
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
        ->deleteJson(route('admin.delete.position', ['position_id' => $position->id]));

    $response->assertOk();
    $response->assertJson(['success' => true]);

    $this->assertDatabaseMissing('positions', [
        'id' => $position->id,
    ]);
});
