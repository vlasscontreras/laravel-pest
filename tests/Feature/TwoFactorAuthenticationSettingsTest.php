<?php

use Laravel\Jetstream\Http\Livewire\TwoFactorAuthenticationForm;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can enable two factor authentication', function () {
    actingAs($user = createUser());

    $this->withSession(['auth.password_confirmed_at' => time()]);

    Livewire::test(TwoFactorAuthenticationForm::class)
        ->call('enableTwoFactorAuthentication');

    $user = $user->fresh();

    $this->assertNotNull($user->two_factor_secret);
    $this->assertCount(8, $user->recoveryCodes());
});

it('can regenerate recovery codes', function () {
    actingAs($user = createUser());

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $component = Livewire::test(TwoFactorAuthenticationForm::class)
            ->call('enableTwoFactorAuthentication')
            ->call('regenerateRecoveryCodes');

    $user = $user->fresh();

    $component->call('regenerateRecoveryCodes');

    $this->assertCount(8, $user->recoveryCodes());
    $this->assertCount(8, array_diff($user->recoveryCodes(), $user->fresh()->recoveryCodes()));
});

it('can disable two factor authentication', function () {
    actingAs($user = createUser());

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $component = Livewire::test(TwoFactorAuthenticationForm::class)
        ->call('enableTwoFactorAuthentication');

    $this->assertNotNull($user->fresh()->two_factor_secret);

    $component->call('disableTwoFactorAuthentication');

    $this->assertNull($user->fresh()->two_factor_secret);
});
