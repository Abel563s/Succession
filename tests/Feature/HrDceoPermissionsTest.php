<?php

use App\Models\CriticalRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows dceo to create critical role records', function () {
    $dceo = User::factory()->create([
        'role' => 'dceo',
        'signature_path' => 'signatures/existing-signature.png',
    ]);

    $response = $this->actingAs($dceo)->post(route('admin.critical-roles.store'), [
        'employee_name' => 'DCEO Candidate',
        'department' => 'Operations',
        'critical_role' => 'Head of Ops',
        'position_status' => 'Filled',
        'vacancy_risk' => 'Low',
        'position_impact' => 'High',
        'mitigation_plan' => 'Retention plan',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('critical_roles', [
        'employee_name' => 'DCEO Candidate',
        'created_by' => $dceo->id,
    ]);
});

it('allows dceo to edit their own critical role records', function () {
    $dceo = User::factory()->create(['role' => 'dceo']);
    $record = CriticalRole::query()->create([
        'employee_name' => 'Owned Record',
        'department' => 'Operations',
        'critical_role' => 'Head of Ops',
        'position_status' => 'Filled',
        'vacancy_risk' => 'Low',
        'position_impact' => 'High',
        'mitigation_plan' => 'Plan',
        'created_by' => $dceo->id,
        'approval_status' => 'Pending',
    ]);

    $response = $this->actingAs($dceo)->put(route('admin.critical-roles.update', $record), [
        'employee_name' => 'Updated Name',
        'department' => $record->department,
        'critical_role' => $record->critical_role,
        'position_status' => $record->position_status,
        'vacancy_risk' => $record->vacancy_risk,
        'position_impact' => $record->position_impact,
        'mitigation_plan' => 'Updated plan',
    ]);

    $response->assertRedirect(route('admin.critical-roles.index'));
    $this->assertDatabaseHas('critical_roles', [
        'id' => $record->id,
        'employee_name' => 'Updated Name',
    ]);
});

it('prevents dceo from editing critical role records created by others', function () {
    $dceo = User::factory()->create(['role' => 'dceo']);
    $manager = User::factory()->create(['role' => 'manager']);
    $record = CriticalRole::query()->create([
        'employee_name' => 'Manager Record',
        'department' => 'Operations',
        'critical_role' => 'Head of Ops',
        'position_status' => 'Filled',
        'vacancy_risk' => 'Low',
        'position_impact' => 'High',
        'mitigation_plan' => 'Plan',
        'created_by' => $manager->id,
        'approval_status' => 'Pending',
    ]);

    $response = $this->actingAs($dceo)->put(route('admin.critical-roles.update', $record), [
        'employee_name' => 'Should Not Update',
        'department' => $record->department,
        'critical_role' => $record->critical_role,
        'position_status' => $record->position_status,
        'vacancy_risk' => $record->vacancy_risk,
        'position_impact' => $record->position_impact,
        'mitigation_plan' => $record->mitigation_plan,
    ]);

    $response->assertForbidden();
});

it('allows dceo to create transition records', function () {
    $dceo = User::factory()->create([
        'role' => 'dceo',
        'signature_path' => 'signatures/existing-signature.png',
    ]);

    $response = $this->actingAs($dceo)->post(route('admin.transition.store'), [
        'department' => 'Operations',
        'status' => 'Planned',
        'items' => [
            [
                'critical_role' => 'Head of Ops',
                'current_holder' => 'Current Holder',
                'successor' => 'Successor Name',
                'transition_date' => now()->addMonth()->toDateString(),
            ],
        ],
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('transitions', [
        'department' => 'Operations',
        'user_id' => $dceo->id,
    ]);
});
