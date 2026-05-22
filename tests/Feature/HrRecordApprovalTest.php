<?php

use App\Models\Coaching;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => 'admin',
    ]);
});

it('defaults new hr records to pending approval', function () {
    $coaching = Coaching::query()->create([
        'candidate_name' => 'Jane Doe',
        'supervisor' => 'John Manager',
        'department' => 'Operations',
        'coaching_date' => now()->toDateString(),
    ]);

    expect($coaching->fresh()->approval_status)->toBe('Pending');
});

it('shows pending approval on the record view page', function () {
    $coaching = Coaching::query()->create([
        'candidate_name' => 'Jane Doe',
        'supervisor' => 'John Manager',
        'department' => 'Operations',
        'coaching_date' => now()->toDateString(),
        'approval_status' => 'Pending',
    ]);

    $response = $this->actingAs($this->admin)->get(route('admin.coaching.show', $coaching));

    $response->assertSuccessful();
    $response->assertSee('Pending Approval');
    $response->assertSee('Approve');
    $response->assertSee('Reject');
});

it('allows admin to approve a pending record', function () {
    $coaching = Coaching::query()->create([
        'candidate_name' => 'Jane Doe',
        'supervisor' => 'John Manager',
        'department' => 'Operations',
        'coaching_date' => now()->toDateString(),
        'approval_status' => 'Pending',
    ]);

    $response = $this->actingAs($this->admin)->post(route('admin.approval.approve', [
        'module' => 'coaching',
        'id' => $coaching->id,
    ]));

    $response->assertRedirect();
    $response->assertSessionHas('success');
    expect($coaching->fresh()->approval_status)->toBe('Approved');
});

it('allows admin to reject a pending record', function () {
    $coaching = Coaching::query()->create([
        'candidate_name' => 'Jane Doe',
        'supervisor' => 'John Manager',
        'department' => 'Operations',
        'coaching_date' => now()->toDateString(),
        'approval_status' => 'Pending',
    ]);

    $response = $this->actingAs($this->admin)->post(route('admin.approval.reject', [
        'module' => 'coaching',
        'id' => $coaching->id,
    ]));

    $response->assertRedirect();
    $response->assertSessionHas('success');
    expect($coaching->fresh()->approval_status)->toBe('Rejected');
});

it('returns not found for unknown approval modules', function () {
    $coaching = Coaching::query()->create([
        'candidate_name' => 'Jane Doe',
        'supervisor' => 'John Manager',
        'department' => 'Operations',
        'coaching_date' => now()->toDateString(),
    ]);

    $response = $this->actingAs($this->admin)->post(route('admin.approval.approve', [
        'module' => 'unknown-module',
        'id' => $coaching->id,
    ]));

    $response->assertNotFound();
});
