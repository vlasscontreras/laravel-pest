<?php

use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Http\Livewire\UpdatePasswordForm;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can update passwords', function () {
    actingAs($user = createUser());

    Livewire::test(UpdatePasswordForm::class)
        ->set('state', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
        ->call('updatePassword');

    $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
});

it('checks that current password is correct', function () {
    actingAs($user = createUser());

    Livewire::test(UpdatePasswordForm::class)
        ->set('state', [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
        ->call('updatePassword')
        ->assertHasErrors(['current_password']);

    $this->assertTrue(Hash::check('password', $user->fresh()->password));
});

it('checks that new passwords match', function () {
    actingAs($user = createUser());

    Livewire::test(UpdatePasswordForm::class)
        ->set('state', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'wrong-password',
        ])
        ->call('updatePassword')
        ->assertHasErrors(['password']);

    $this->assertTrue(Hash::check('password', $user->fresh()->password));
});
