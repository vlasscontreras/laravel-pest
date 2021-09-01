<?php

use App\Models\Repository;

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

it('can create a new repository', function () {
    actingAs(createUser());

    $data = [
        'url'         => faker()->url(),
        'description' => faker()->text(50),
    ];

    post('repositories', $data)->assertRedirect('repositories');

    assertDatabaseHas('repositories', $data);
});

it('prevents the repository creation if the request has invalid data', function () {
    actingAs(createUser());

    post('repositories', [])->assertRedirect()
        ->assertSessionHasErrors(['url', 'description']);

    post('repositories', ['url' => 'a', 'description' => 'Something'])->assertRedirect()
        ->assertSessionHasErrors(['url']);
});

it('can update an existing repository', function () {
    $repository = Repository::factory()->create();

    actingAs($repository->user);

    $data = [
        'url'         => faker()->url(),
        'description' => faker()->text(50),
    ];

    patch("repositories/$repository->id", $data)->assertRedirect("repositories/$repository->id/edit");

    assertDatabaseHas('repositories', $data);
});

it('prevents the repository update if the request has invalid data', function () {
    $repository = Repository::factory()->create();

    actingAs($repository->user);

    patch("repositories/$repository->id", ['url' => 'a'])->assertRedirect()
        ->assertSessionHasErrors(['url']);
});
