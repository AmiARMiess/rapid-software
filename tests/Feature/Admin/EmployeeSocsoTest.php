<?php

use App\Models\User;

it('renders the employee creation page for admin users', function () {
    $user = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($user)->get(route('admin.create.employee'));

    $response->assertStatus(200);
    $response->assertSee('Monthly Salary');
});

it('calculates socso contributions from monthly salary', function () {
    $user = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($user)->post(route('admin.calculate.socso'), [
        'monthly_salary' => 3000,
    ]);

    $response->assertStatus(200);
    $response->assertSee('Employee contribution: RM 14.75');
    $response->assertSee('Employer contribution: RM 51.65');
    $response->assertSee('Total contribution: RM 66.40');
});

it('validates monthly salary input when calculating socso', function () {
    $user = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($user)->post(route('admin.calculate.socso'), [
        'monthly_salary' => -1,
    ]);

    $response->assertSessionHasErrors('monthly_salary');
});
