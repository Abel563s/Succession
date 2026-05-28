<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows creating a manager without a signature image', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->post(route('admin.users.store'), [
        'name' => 'Manager Without Signature',
        'email' => 'manager-nosig@example.com',
        'role' => 'manager',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'is_active' => '1',
    ]);

    $response->assertRedirect(route('admin.users.index'));
    $this->assertDatabaseHas('users', [
        'email' => 'manager-nosig@example.com',
        'role' => 'manager',
    ]);
});

it('updates user counters based on active filters', function () {
    $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
    User::factory()->create(['role' => 'manager', 'is_active' => true]);
    User::factory()->create(['role' => 'manager', 'is_active' => false]);
    User::factory()->create(['role' => 'user', 'is_active' => false]);

    $response = $this->actingAs($admin)->get(route('admin.users.index', [
        'role' => 'manager',
    ]));

    $response->assertSuccessful();
    expect($response->viewData('totalUsers'))->toBe(2);
    expect($response->viewData('activeUsers'))->toBe(1);
    expect($response->viewData('adminUsers'))->toBe(0);
    expect($response->viewData('deptUsers'))->toBe(2);
    expect($response->viewData('disabledUsers'))->toBe(1);
});
