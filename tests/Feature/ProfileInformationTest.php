<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can read the current profile information', function () {
    actingAs($user = User::factory()->create());

    $component = Livewire::test(UpdateProfileInformationForm::class);

    $this->assertEquals($user->name, $component->state['name']);
    $this->assertEquals($user->email, $component->state['email']);
});

it('can update profile information', function () {
    actingAs($user = User::factory()->create());

    Livewire::test(UpdateProfileInformationForm::class)
        ->set('state', ['name' => 'Test Name', 'email' => 'test@example.com'])
        ->call('updateProfileInformation');

    $this->assertEquals('Test Name', $user->fresh()->name);
    $this->assertEquals('test@example.com', $user->fresh()->email);
});
