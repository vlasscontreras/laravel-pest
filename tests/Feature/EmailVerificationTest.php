<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Features;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can render the email verification screen', function () {
    if (! Features::enabled(Features::emailVerification())) {
        return $this->markTestSkipped('Email verification not enabled.');
    }

    $user = User::factory()->withPersonalTeam()->create([
        'email_verified_at' => null,
    ]);

    actingAs($user);

    get('/email/verify')->assertStatus(200);
});

it('can verify emails', function () {
    if (! Features::enabled(Features::emailVerification())) {
        return $this->markTestSkipped('Email verification not enabled.');
    }

    Event::fake();

    $user = createUser([
        'email_verified_at' => null,
    ]);

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    actingAs($user);
    get($verificationUrl)->assertRedirect(RouteServiceProvider::HOME . '?verified=1');

    Event::assertDispatched(Verified::class);

    $this->assertTrue($user->fresh()->hasVerifiedEmail());
});

it('cannot verify emails with invalid hash', function () {
    if (! Features::enabled(Features::emailVerification())) {
        return $this->markTestSkipped('Email verification not enabled.');
    }

    $user = createUser([
        'email_verified_at' => null,
    ]);

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    actingAs($user)->get($verificationUrl);

    $this->assertFalse($user->fresh()->hasVerifiedEmail());
});
