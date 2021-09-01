<?php

use App\Models\Repository;
use App\Models\User;

uses(\Tests\TestCase::class);
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('belongs to user', function () {
    $repository = Repository::factory()->create();

    expect($repository->user)->toBeInstanceOf(User::class);
});
