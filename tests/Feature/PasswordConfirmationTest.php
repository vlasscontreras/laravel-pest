<?php

use App\Models\User;
use Laravel\Jetstream\Features;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can render password confirmation screen', function () {
    $user = Features::hasTeamFeatures()
        ? User::factory()->withPersonalTeam()->create()
        : createUser();

    actingAs($user);

    get('/user/confirm-password')->assertStatus(200);
});

it('can confirm passwords', function () {
    actingAs($user = createUser());

    post('/user/confirm-password', [
        'password' => 'password',
    ])->assertRedirect()->assertSessionHasNoErrors();
});

it('prevents password confirmation with invalid password', function () {
    actingAs($user = createUser());

    post('/user/confirm-password', [
        'password' => 'wrong-password',
    ])->assertSessionHasErrors();
});
