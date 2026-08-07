<?php

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\LaravelPdf\Facades\Pdf;

it('downloads the department report as a PDF', function () {
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
        'description' => 'A report download test.',
    ]);

    Pdf::fake();

    $response = $this->actingAs($user)
        ->get(route('admin.print.department', ['department_id' => $department->id]));

    $response->assertStatus(200);

    Pdf::assertRespondedWithPdf(fn ($pdf) =>
        $pdf->viewName === 'admin.pdf.department_info'
        && $pdf->viewData['department']->id === $department->id
        && $pdf->viewData['countTotalPosition'] === 0
        && $pdf->viewData['countTotalEmployee'] === 0
        && $pdf->downloadName === "department-{$department->id}.pdf"
    );
});
