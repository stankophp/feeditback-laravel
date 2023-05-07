<?php

use App\Models\Genre;
use App\Models\Movie;
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

it('does not create a movie without a name field', function () {
    $movie = Movie::factory()->create(['name' => ''])->toArray();
    $response = $this->postJson('/movies', $movie);
    $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
});

it('does not create a movie without a description field', function () {
    $movie = Movie::factory()->create(['description' => ''])->toArray();
    $response = $this->postJson('/movies', $movie);
    $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
});

it('does not create a movie without a image field', function () {
    $movie = Movie::factory()->create(['image' => ''])->toArray();
    $response = $this->postJson('/movies', $movie);
    $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
});

it('does not create a movie without a release_date field', function () {
    $movie = Movie::factory()->create(['release_date' => ''])->toArray();
    $response = $this->postJson('/movies', $movie);
    $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
});

it('does not create a movie without a rating field', function () {
    $movie = Movie::factory()->create(['rating' => ''])->toArray();
    $response = $this->postJson('/movies', $movie);
    $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
});

it('does create a movie without a award_winning field', function () {
    $movie = Movie::factory()->create(['award_winning' => 0,])->toArray();
    $genres = Genre::factory(2)->create();
    $movie['genres'] = [1,2];
    $response = $this->postJson('/movies', $movie);
    $response->assertStatus(SymfonyResponse::HTTP_CREATED);
});

it('does create a movie with a award_winning field', function () {
    $movie = Movie::factory()->create(['award_winning' => 1,])->toArray();
    $genres = Genre::factory(2)->create();
    $movie['genres'] = [1,2];
    $response = $this->postJson('/movies', $movie);
    $response->assertStatus(SymfonyResponse::HTTP_CREATED);
});

it('does update a movie with a award_winning field', function () {
    $movie = Movie::factory()->create(['award_winning' => 0,]);
    $genres = Genre::factory(2)->create();
    $this->assertDatabaseHas(
        'movies',
        [
            'id' => 1,
            'award_winning' => 0,
        ]
    );

    $response = $this->patchJson('/movies/' . $movie->id, [
        'name' => 'name',
        'description' => $movie->description,
        'image' => $movie->image,
        'rating' => $movie->rating,
        'release_date' => $movie->release_date,
        'award_winning' => 1,
        'genres' => [1],
    ]);
    $response->assertStatus(SymfonyResponse::HTTP_ACCEPTED);

    $this->assertDatabaseHas(
        'movies',
        [
            'id' => 1,
            'name' => 'name',
            'award_winning' => 1,
        ]
    );
});

