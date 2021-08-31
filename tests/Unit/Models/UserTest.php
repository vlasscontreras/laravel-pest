<?php

use App\Models\User;

uses(\Tests\TestCase::class);

it('has many repositories', function () {
    $user = new User();

    expect($user->repositories)->toBeCollection();
});
