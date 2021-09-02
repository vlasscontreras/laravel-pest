<?php

use App\Models\Repository;

use function Pest\Faker\faker;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
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

it('renders the list of owned repositories', function () {
    $repository = Repository::factory()->create();

    actingAs($repository->user);

    get('repositories')
        ->assertOk()
        ->assertSee($repository->name)
        ->assertSee($repository->url);
});

it('does not render repositories owned by other users', function () {
    $repository = Repository::factory()->create();

    actingAs(createUser());

    get('repositories')
        ->assertOk()
        ->assertDontSee($repository->url)
        ->assertSee('No repositories found.');
});

it('renders the repository page of an owned repository', function () {
    $repository = Repository::factory()->create();

    actingAs($repository->user);

    get("repositories/$repository->id")
        ->assertOk()
        ->assertSee($repository->url);
});

it('does not show the repository page for repositories owned by someone else', function () {
    $repository = Repository::factory()->create();

    actingAs(createUser());

    get("repositories/$repository->id")
        ->assertForbidden();
});

it('renders the create repository screen', function () {
    actingAs(createUser());

    get('repositories/create')
        ->assertOk()
        ->assertSee(__('Create Repository'));
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

it('renders the edit screen for owned repositories', function () {
    $repository = Repository::factory()->create();

    actingAs($repository->user);

    get("repositories/$repository->id/edit")
        ->assertOk()
        ->assertSee($repository->url)
        ->assertSee($repository->description);
});

it('does not render the edit screen for repositories owned by someone else', function () {
    $repository = Repository::factory()->create();

    actingAs(createUser());

    get("repositories/$repository->id/edit")
        ->assertForbidden();
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

it('prevents users from updating repositories they do not own', function () {
    $repository = Repository::factory()->create();

    actingAs(createUser());

    $data = ['url' => faker()->url()];

    patch("repositories/$repository->id", $data)->assertStatus(403);

    assertDatabaseMissing('repositories', array_merge($data, ['id' => $repository->id]));
});

it('can delete an existing repository', function () {
    $repository = Repository::factory()->create();

    actingAs($repository->user);

    delete("repositories/$repository->id")->assertRedirect('repositories');

    assertDatabaseMissing('repositories', [
        'id'          => $repository->id,
        'url'         => $repository->url,
        'description' => $repository->description,
    ]);
});

it('shows a 404 when attempting to delete a repository that does not exist', function () {
    actingAs(createUser());

    delete('repositories/3446531462514234')->assertNotFound();
});

it('prevents users from deleting repositories they do not own', function () {
    $repository = Repository::factory()->create();

    actingAs(createUser());

    delete("repositories/$repository->id")->assertStatus(403);

    assertDatabaseHas('repositories', [
        'id'          => $repository->id,
        'url'         => $repository->url,
        'description' => $repository->description,
    ]);
});
