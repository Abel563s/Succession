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
