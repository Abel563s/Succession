<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

it('authenticates successfully with mixed-case email input', function () {
    Http::fake([
        'https://challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
            'success' => true,
        ], 200),
    ]);

    $user = User::factory()->create([
        'email' => 'manager@example.com',
        'password' => bcrypt('password123'),
        'is_active' => true,
    ]);

    $response = $this->post(route('login'), [
        'email' => 'Manager@Example.COM',
        'password' => 'password123',
        'cf-turnstile-response' => 'test-token',
    ]);

    $response->assertRedirect(route('dashboard', absolute: false));
    $this->assertAuthenticatedAs($user);
});
