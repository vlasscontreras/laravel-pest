<?php

use App\Models\Repository;

use function Pest\Laravel\get;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('all repositories can be listed on the public side', function () {
    $repositories = Repository::factory(10)->create();
    $repository = $repositories->random();

    get('/')
        ->assertOk()
        ->assertSee($repository->url);
});
