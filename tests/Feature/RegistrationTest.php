<?php

use App\Providers\RouteServiceProvider;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can render the registration screen', function () {
    if (! Features::enabled(Features::registration())) {
        return $this->markTestSkipped('Registration support is not enabled.');
    }

    get('/register')->assertStatus(200);
});

it('does not show the registration screen if support is disabled', function () {
    if (Features::enabled(Features::registration())) {
        return $this->markTestSkipped('Registration support is enabled.');
    }

    get('/register')->assertStatus(404);
});

it('can register new users', function () {
    if (! Features::enabled(Features::registration())) {
        return $this->markTestSkipped('Registration support is not enabled.');
    }

    post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    ])->assertRedirect(RouteServiceProvider::HOME);

    $this->assertAuthenticated();
});
