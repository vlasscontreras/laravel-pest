<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Jetstream\Features;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can render password confirmation screen', function () {
    $user = Features::hasTeamFeatures()
        ? User::factory()->withPersonalTeam()->create()
        : User::factory()->create();

    actingAs($user);

    get('/user/confirm-password')->assertStatus(200);
});

it('can confirm passwords', function () {
    $user = User::factory()->create();

    actingAs($user);

    post('/user/confirm-password', [
        'password' => 'password',
    ])->assertRedirect()->assertSessionHasNoErrors();
});

it('prevents password confirmation with invalid password', function () {
    $user = User::factory()->create();

    actingAs($user);

    post('/user/confirm-password', [
        'password' => 'wrong-password',
    ])->assertSessionHasErrors();
});
