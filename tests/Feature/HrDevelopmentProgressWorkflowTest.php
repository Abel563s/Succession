<?php

use App\Models\Development;
use App\Models\ProgressReview;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
    $this->admin = User::factory()->create(['role' => 'admin']);
});

it('creates development plan without scores and links progress review', function () {
    $objectives = [];
    for ($i = 0; $i < 5; $i++) {
        $objectives[$i] = [
            'objective' => "Objective {$i}",
            'activity' => "Activity {$i}",
            'resource' => "Resource {$i}",
            'start_date' => now()->toDateString(),
            'delivery_date' => now()->addMonth()->toDateString(),
            'expected_outcome' => "Outcome {$i}",
        ];
    }

    $response = $this->actingAs($this->admin)->post(route('admin.development.store'), [
        'employee_name' => 'Alex Employee',
        'department' => 'Operations',
        'line_manager' => 'Manager One',
        'signature' => UploadedFile::fake()->create('manager.jpg', 100, 'image/jpeg'),
        'candidate_signature' => UploadedFile::fake()->create('candidate.jpg', 100, 'image/jpeg'),
        'objectives' => $objectives,
    ]);

    $development = Development::query()->first();
    $progress = ProgressReview::query()->first();

    $response->assertRedirect(route('admin.progress.edit', $progress));
    expect($development)->not->toBeNull();
    expect($development->objectives)->toHaveCount(5);
    expect($development->objectives->first()->score)->toBeNull();
    expect($progress)->not->toBeNull();
    expect($progress->development_id)->toBe($development->id);
    expect($progress->idpObjectives)->toHaveCount(5);
});

it('prevents managers from editing records they did not create', function () {
    $managerA = User::factory()->create(['role' => 'manager']);
    $managerB = User::factory()->create(['role' => 'manager']);

    $development = Development::query()->create([
        'employee_name' => 'Test',
        'department' => 'Ops',
        'line_manager' => 'A',
        'created_by' => $managerA->id,
    ]);

    $this->actingAs($managerB)
        ->get(route('admin.development.edit', $development))
        ->assertForbidden();
});

it('stores manager signature on user profile when admin creates manager', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.users.store'), [
        'name' => 'Manager Sig',
        'email' => 'manager-sig@test.com',
        'role' => 'manager',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'is_active' => 1,
        'signature' => UploadedFile::fake()->create('sig.png', 100, 'image/png'),
    ]);

    $response->assertRedirect(route('admin.users.index'));
    expect(User::query()->where('email', 'manager-sig@test.com')->first()->signature_path)->not->toBeNull();
});

it('requires signature when admin creates a manager', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.users.store'), [
        'name' => 'Manager No Sig',
        'email' => 'manager-nosig@test.com',
        'role' => 'manager',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'is_active' => 1,
    ]);

    $response->assertSessionHasErrors('signature');
});
