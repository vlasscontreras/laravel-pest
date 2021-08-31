<?php

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\ApiTokenManager;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can update api token permissions', function () {
    if (!Features::hasApiFeatures()) {
        $this->markTestSkipped('API features are not enabled.');
    }

    if (Features::hasTeamFeatures()) {
        actingAs($user = User::factory()->withPersonalTeam()->create());
    } else {
        actingAs($user = User::factory()->create());
    }

    $token = $user->tokens()->create([
        'name' => 'Test Token',
        'token' => Str::random(40),
        'abilities' => ['create', 'read'],
    ]);

    Livewire::test(ApiTokenManager::class)
        ->set(['managingPermissionsFor' => $token])
        ->set(['updateApiTokenForm' => [
            'permissions' => [
                'delete',
                'missing-permission',
            ],
        ]])
        ->call('updateApiToken');

    $this->assertTrue($user->fresh()->tokens->first()->can('delete'));
    $this->assertFalse($user->fresh()->tokens->first()->can('read'));
    $this->assertFalse($user->fresh()->tokens->first()->can('missing-permission'));
});
