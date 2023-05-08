<?php

use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

uses(DatabaseMigrations::class, RefreshDatabase::class);

test('this is an example test', function() {
    $this->assertEquals(1, 1);
});

test('read list of movies', function() {
    $movie1 = Movie::factory()->make();
    $movie2 = Movie::factory()->make();
    $movie3 = Movie::factory()->make();
    $response = $this->get('/movies');

    $response->assertStatus(SymfonyResponse::HTTP_OK);
    $response->assertSee($movie1->title);
    $response->assertSee($movie2->title);
    $response->assertSee($movie3->title);
    $this->assertEquals(1, 1);
});

test('read single movie', function() {
    $movie1 = Movie::factory()->make();
    $response = $this->get('/movies/' . $movie1->id);

    $response->assertStatus(SymfonyResponse::HTTP_OK);
    $response->assertSee($movie1->title);
});

it('unauthorised user may not create a movie', function () {
    $movie = Movie::factory()->create(['name' => ''])->toArray();
    $response = $this->postJson('/movies', $movie);
    $response->assertStatus(SymfonyResponse::HTTP_UNAUTHORIZED);
});

it('does not create a movie without a name field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $movie = Movie::factory()->create(['name' => ''])->toArray();
    $response = $this->postJson('/movies', $movie);
    $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
});

it('does not create a movie without a description field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $movie = Movie::factory()->create(['description' => ''])->toArray();
    $response = $this->postJson('/movies', $movie);
    $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
});

it('does not create a movie without a image field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $movie = Movie::factory()->create(['image' => ''])->toArray();
    $response = $this->postJson('/movies', $movie);
    $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
});

it('does not create a movie without a release_date field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $movie = Movie::factory()->create(['release_date' => ''])->toArray();
    $response = $this->postJson('/movies', $movie);
    $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
});

it('does not create a movie without a rating field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $movie = Movie::factory()->create(['rating' => ''])->toArray();
    $response = $this->postJson('/movies', $movie);
    $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
});

it('does create a movie without a award_winning field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $movie = Movie::factory()->create(['award_winning' => 0,])->toArray();
    $genres = Genre::factory(2)->create();
    $movie['genres'] = [1,2];
    $response = $this->postJson('/movies', $movie);
    $response->assertStatus(SymfonyResponse::HTTP_CREATED);
});

it('does create a movie with a award_winning field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $movie = Movie::factory()->create(['award_winning' => 1,])->toArray();
    $genres = Genre::factory(2)->create();
    $movie['genres'] = [1,2];
    $response = $this->postJson('/movies', $movie);
    $response->assertStatus(SymfonyResponse::HTTP_CREATED);
});

it('unauthorised user may not update a movie', function () {
    $movie = Movie::factory()->create();
    $response = $this->patchJson('/movies/' . $movie->id, [
        'name' => 'name and name',
        'description' => $movie->description,
        'image' => $movie->image,
        'rating' => 6,
        'release_date' => $movie->release_date,
        'award_winning' => 1,
        'genres' => [1],
    ]);
    $response->assertStatus(SymfonyResponse::HTTP_UNAUTHORIZED);
});

it('does update a movie with a award_winning and rating field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $movie = Movie::factory()->create(['award_winning' => 0, 'user_id' => $user->id]);
    $genres = Genre::factory(2)->create();
    $this->assertDatabaseHas(
        'movies',
        [
            'id' => 1,
            'award_winning' => 0,
        ]
    );

    $response = $this->patchJson('/movies/' . $movie->id, [
        'name' => 'name and name',
        'description' => $movie->description,
        'image' => $movie->image,
        'rating' => 6,
        'release_date' => $movie->release_date,
        'award_winning' => 1,
        'genres' => [1],
    ]);
    $response->assertStatus(SymfonyResponse::HTTP_ACCEPTED);

    $this->assertDatabaseHas(
        'movies',
        [
            'id' => 1,
            'name' => 'name and name',
            'award_winning' => 1,
            'rating' => 6,
        ]
    );
});

it('does not update a movie that does not belong to them', function () {
    $user1 = User::factory()->create();
    $this->actingAs($user1);

    $user2 = User::factory()->create();
    $movie = Movie::factory()->create(['award_winning' => 0, 'user_id' => $user2->id]);

    $response = $this->patchJson('/movies/' . $movie->id, [
        'name' => 'name and name',
        'description' => $movie->description,
        'image' => $movie->image,
        'rating' => 6,
        'release_date' => $movie->release_date,
        'award_winning' => 1,
        'genres' => [1],
    ]);
    $response->assertStatus(SymfonyResponse::HTTP_FORBIDDEN);
});

it('does update a movie that does belong to them', function () {
    $user1 = User::factory()->create();
    $this->actingAs($user1);

    $movie = Movie::factory()->create(['award_winning' => 0, 'user_id' => $user1->id]);
    $genres = Genre::factory(2)->create();
    $this->assertDatabaseHas(
        'movies',
        [
            'id' => 1,
            'award_winning' => 0,
        ]
    );

    $response = $this->patchJson('/movies/' . $movie->id, [
        'name' => 'name and name',
        'description' => $movie->description,
        'image' => $movie->image,
        'rating' => 6,
        'release_date' => $movie->release_date,
        'award_winning' => 1,
        'genres' => [1],
    ]);
    $response->assertStatus(SymfonyResponse::HTTP_ACCEPTED);

    $this->assertDatabaseHas(
        'movies',
        [
            'id' => 1,
            'name' => 'name and name',
            'award_winning' => 1,
            'rating' => 6,
        ]
    );
});

it('does not delete a movie that does not belong to them', function () {
    $user1 = User::factory()->create();
    $this->actingAs($user1);

    $user2 = User::factory()->create();
    $movie = Movie::factory()->create(['user_id' => $user2->id]);

    $response = $this->delete('/movies/' . $movie->id);
    $response->assertStatus(SymfonyResponse::HTTP_FORBIDDEN);
});

it('does delete a movie that does not belong to them', function () {
    $user1 = User::factory()->create();
    $this->actingAs($user1);

    $movie = Movie::factory()->create(['award_winning' => 0, 'user_id' => $user1->id]);

    $this->assertDatabaseHas(
        'movies',
        [
            'id' => 1,
        ]
    );

    $response = $this->deleteJson('/movies/' . $movie->id);
    $response->assertStatus(SymfonyResponse::HTTP_ACCEPTED);

    $this->assertDatabaseMissing(
        'movies',
        [
            'id' => 1,
        ]
    );
});

