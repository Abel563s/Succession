<?php

use App\Models\CriticalRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows admin to view the hr report page', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    CriticalRole::query()->create([
        'employee_name' => 'Test Employee',
        'department' => 'Operations',
        'critical_role' => 'Director',
        'position_status' => 'Filled',
        'vacancy_risk' => 'Low',
        'position_impact' => 'High',
        'mitigation_plan' => 'Plan',
        'approval_status' => 'Pending',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.reports.index'));

    $response->assertSuccessful();
    $response->assertSee('HR Succession & Development Report', false);
    $response->assertSee('Executive Summary');
    $response->assertSee('Critical Roles');
    $response->assertSee('Test Employee');
});

it('filters report by department', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    CriticalRole::query()->create([
        'employee_name' => 'In Ops',
        'department' => 'Operations',
        'critical_role' => 'Role',
        'position_status' => 'Filled',
        'vacancy_risk' => 'Low',
        'position_impact' => 'High',
        'mitigation_plan' => 'Plan',
    ]);

    CriticalRole::query()->create([
        'employee_name' => 'In HR',
        'department' => 'Human Resources',
        'critical_role' => 'Role',
        'position_status' => 'Filled',
        'vacancy_risk' => 'Low',
        'position_impact' => 'High',
        'mitigation_plan' => 'Plan',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.reports.index', ['department' => 'Operations']));

    $response->assertSuccessful();
    $response->assertSee('In Ops');
    $response->assertDontSee('In HR');
});

it('denies access to non-admin users for the hr report page', function () {
    $user = User::factory()->create(['role' => 'user']);
    $response = $this->actingAs($user)->get(route('admin.reports.index'));
    $response->assertStatus(403);
});

it('denies access to managers for the hr report page', function () {
    $manager = User::factory()->create(['role' => 'manager']);
    $response = $this->actingAs($manager)->get(route('admin.reports.index'));
    $response->assertStatus(403);
});

it('denies access to dceo users for the hr report page', function () {
    $dceo = User::factory()->create(['role' => 'dceo']);
    $response = $this->actingAs($dceo)->get(route('admin.reports.index'));
    $response->assertStatus(403);
});
