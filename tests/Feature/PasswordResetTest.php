<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Features;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can render the password reset link screen', function () {
    if (! Features::enabled(Features::updatePasswords())) {
        return $this->markTestSkipped('Password updates are not enabled.');
    }

    get('/forgot-password')->assertStatus(200);
});

it('can request password reset link', function () {
    if (! Features::enabled(Features::updatePasswords())) {
        return $this->markTestSkipped('Password updates are not enabled.');
    }

    Notification::fake();

    $user = User::factory()->create();

    post('/forgot-password', [
        'email' => $user->email,
    ]);

    Notification::assertSentTo($user, ResetPassword::class);
});

it('can render the password reset screen', function () {
    if (! Features::enabled(Features::updatePasswords())) {
        return $this->markTestSkipped('Password updates are not enabled.');
    }

    Notification::fake();

    $user = User::factory()->create();

    post('/forgot-password', [
        'email' => $user->email,
    ]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        get('/reset-password/' . $notification->token)->assertStatus(200);
        return true;
    });
});

it('can reset password with a valid token', function () {
    if (! Features::enabled(Features::updatePasswords())) {
        return $this->markTestSkipped('Password updates are not enabled.');
    }

    Notification::fake();

    $user = User::factory()->create();

    post('/forgot-password', [
        'email' => $user->email,
    ]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        post('/reset-password', [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertSessionHasNoErrors();

        return true;
    });
});
