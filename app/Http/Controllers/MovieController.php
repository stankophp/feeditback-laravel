<?php

namespace App\Http\Controllers;

use App\Filters\MovieFilter;
use App\Http\Requests\MovieStoreRequest;
use App\Http\Requests\MovieUpdateRequest;
use App\Models\Movie;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class MovieController extends Controller
{
    public function index(Request $request, MovieFilter $filter)
    {
        /**
         * A user can filter movies by the following:
         * Release date
         * Genres
         * Actors
         *
         * Write code which will return movies based on these filters.
         * Filters will be passed as query parameters.
         * A user can pass multiple genres/actors
         * All filters are optional
         * If genres and actors are present results must match one OR the other.
         *
         * You should seed 5000 movies (with related data) using the factory for this endpoint to use.
         *
         * When returning the user data we want to emit the user_id of the user which created the movie.
         * Use a JsonResource to return results
         */
        $movies = $this->getMovies($filter);

        if ($request->wantsJson()) {
            return response($movies, SymfonyResponse::HTTP_OK);
        }

        return view('movies.index', compact('movies'));
    }

    public function show(Request $request, Movie $movie)
    {
        $movie->load(['user', 'genres', 'actors']);
        if ($request->wantsJson()) {
            return response($movie, SymfonyResponse::HTTP_OK);
        }
        return view('movies.show', compact(['movie']));
    }

    public function store(MovieStoreRequest $request)
    {
        /**
         * A user can create a movie and link it to genres/actors
         *
         * Write code which will allow a user to create the movie with the associated data
         * Be sure to have appropriate validation.
         */

        $movie = new Movie();
        $movie->name = $request->input('name');
        $movie->user_id = auth()->id();
        $movie->description = $request->input('description');
        $movie->image = $request->input('image');
        $movie->rating = $request->input('rating');
        $movie->release_date = $request->input('release_date');
        $movie->award_winning = (bool)((int)$request->input('award_winning'));
        $movie->save();

        $movie->genres()->sync($request->input('genres'));

        return response()->json(
            ['data' => $movie],
            SymfonyResponse::HTTP_CREATED
        );
    }

    public function update(MovieUpdateRequest $request, Movie $movie)
    {
        $movie->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),
            'rating' => $request->input('rating'),
            'release_date' => $request->input('release_date'),
            'award_winning' => (bool)((int)$request->input('award_winning')),
        ]);

        $movie->genres()->sync($request->input('genres'));

        if ($request->wantsJson()) {
            return response()->json(
                ['data' => $movie],
                SymfonyResponse::HTTP_ACCEPTED
            );
        }

        return redirect('/movies');
    }

    public function destroy(Request $request, Movie $movie)
    {
        $this->authorize('update', $movie);

        $movie->delete();

        if ($request->wantsJson()) {
            return response([], SymfonyResponse::HTTP_ACCEPTED);
        }

        return redirect('/movies');
    }

    private function getMovies(MovieFilter $filter)
    {
        return Movie::latest()
            ->filter($filter)
            ->with(['user', 'genres', 'actors'])
            ->paginate(10);
    }
}
