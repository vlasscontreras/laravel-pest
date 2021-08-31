<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can render the login screen', function () {
    get('/login')->assertStatus(200);
});

it('lets users authenticate using the login screen', function () {
    $user = User::factory()->create();

    post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(RouteServiceProvider::HOME);

    $this->assertAuthenticated();
});

it('prevents users to authenticate using invalid credentials', function () {
    $user = User::factory()->create();

    post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});
