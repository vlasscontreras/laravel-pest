<?php

use function Pest\Faker\faker;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('requires authentication to render the repository listings and details', function () {
    get('repositories')->assertRedirect('login');
    get('repositories/1')->assertRedirect('login');
});

it('requires authentication to render and submit the create repository screen', function () {
    get('repositories/create')->assertRedirect('login');
    post('repositories', [])->assertRedirect('login');
});

it('requires authentication to edit a repository', function () {
    get('repositories/1/edit')->assertRedirect('login');
    patch('repositories/1')->assertRedirect('login');
});

it('requires authentication to delete a repository', function () {
    delete('repositories/1')->assertRedirect('login');
});

it('can store a new repository', function () {
    actingAs(createUser());

    $data = [
        'url'         => faker()->url(),
        'description' => faker()->text(50),
    ];

    post('repositories', $data)->assertRedirect('repositories');

    assertDatabaseHas('repositories', $data);
});
