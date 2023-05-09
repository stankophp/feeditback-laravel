<?php


use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Tests\TestCase;

class MoviePUTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function non_authenticated_user_may_see_list_of_movies()
    {
        $movie1 = Movie::factory()->make();
        $movie2 = Movie::factory()->make();
        $movie3 = Movie::factory()->make();
        $response = $this->getJson('/movies');

        $response->assertStatus(SymfonyResponse::HTTP_OK);
        $response->assertSee($movie1->title);
        $response->assertSee($movie2->title);
        $response->assertSee($movie3->title);
    }

    /** @test */
    public function non_authenticated_user_may_see_single_movie()
    {
        $movie1 = Movie::factory()->create();
        $response = $this->getJson('/movies/' . $movie1->id);

        $response->assertStatus(SymfonyResponse::HTTP_OK);
        $response->assertSee($movie1->title);
        $response->assertSee($movie1->description);
    }

    /** @test */
    public function unauthorised_user_may_not_create_a_movie()
    {
        $movie = Movie::factory()->create()->toArray();
        $response = $this->postJson('/movies', $movie);
        $response->assertStatus(SymfonyResponse::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function authorised_user_may_not_create_a_movie_without_a_name_field()
    {
        $this->signIn();
        $movie = Movie::factory()->create(['name' => ''])->toArray();
        $response = $this->postJson('/movies', $movie);
        $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function authorised_user_may_not_create_a_movie_without_a_description_field()
    {
        $this->signIn();
        $movie = Movie::factory()->create(['description' => ''])->toArray();
        $response = $this->postJson('/movies', $movie);
        $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function authorised_user_may_not_create_a_movie_without_a_release_date_field()
    {
        $this->signIn();
        $movie = Movie::factory()->create(['release_date' => ''])->toArray();
        $response = $this->postJson('/movies', $movie);
        $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function authorised_user_may_not_create_a_movie_without_a_rating_field()
    {
        $this->signIn();
        $movie = Movie::factory()->create(['rating' => ''])->toArray();
        $response = $this->postJson('/movies', $movie);
        $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function authorised_user_may_create_a_movie_without_a_award_winning_field()
    {
        $this->signIn();
        $movie = Movie::factory()->create(['award_winning' => ''])->toArray();
        $response = $this->postJson('/movies', $movie);
        $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function authorised_user_may_create_a_movie_with_a_award_winning_field()
    {
        $this->signIn();
        $movie = Movie::factory()->create(['award_winning' => 1])->toArray();
        $response = $this->postJson('/movies', $movie);
        $response->assertStatus(SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function unauthorised_user_may_not_update_a_movie()
    {
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
    }

    /** @test */
    public function authorised_user_may_update_movie_award_winning_and_rating_field()
    {
        $user = $this->signIn();
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
    }

    /** @test  */
    public function authorised_user_may_not_update_a_movie_that_does_not_belong_to_them()
    {
        $user1 = $this->signIn();

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
    }

    /** @test  */
    public function authorised_user_may_update_a_movie_that_belongs_to_them()
    {
        $user = $this->signIn();

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
    }

    /** @test  */
    public function unauthorised_user_may_not_delete_a_movie()
    {
        $movie = Movie::factory()->create();
        $response = $this->deleteJson('/movies/' . $movie->id);
        $response->assertStatus(SymfonyResponse::HTTP_UNAUTHORIZED);
    }

    /** @test  */
    public function authorised_user_may_not_delete_a_movie_that_does_not_belong_to_them()
    {
        $user1 = $this->signIn();

        $user2 = User::factory()->create();
        $movie = Movie::factory()->create(['user_id' => $user2->id]);

        $response = $this->deleteJson('/movies/' . $movie->id);
        $response->assertStatus(SymfonyResponse::HTTP_FORBIDDEN);
    }

    /** @test  */
    public function authorised_user_may_delete_a_movie_that_belongs_to_them()
    {
        $user = $this->signIn();

        $movie = Movie::factory()->create(['award_winning' => 0, 'user_id' => $user->id]);

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
    }
}
