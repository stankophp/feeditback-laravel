<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class MovieController extends Controller
{
    public function index(Request $request)
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
        $data = [];

        return response()->json(
            ['data' => Movie::all()],
            SymfonyResponse::HTTP_OK
        );

        $movieIDs = [];
        $searchParams = ['name', 'release_date',];
        $searchResults = (new Search())
            ->registerModel(Movie::class, $searchParams)
            ->search((string)$request->input('search'));

        if ($searchResults->isNotEmpty()) {
            foreach ($searchResults as $result) {
                $movieIDs[] = $result->searchable->id;
            }
        }

        $searchResults = (new Search())
            ->registerModel(Movie::class, $searchParams)
            ->search((string)$request->input('search'));

        if ($searchResults->isNotEmpty()) {
            foreach ($searchResults as $result) {
                $movieIDs[] = $result->searchable->id;
            }
        }


        $data = Movie::whereIn('id', $movieIDs)
            ->with('actors', 'genres')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json(
            ['data' => $data],
            SymfonyResponse::HTTP_OK
        );

    }

    public function store(Request $request)
    {
        /**
         * A user can create a movie and link it to genres/actors
         *
         * Write code which will allow a user to create the movie with the associated data
         * Be sure to have appropriate validation.
         */
        $request->validate([
            'name' => ['required', 'min:1', 'max:240',],
            'description' => ['required', 'min:1', 'max:2400',],
            'image' => ['required', ],
            'release_date' => ['required', 'date'],
            'rating' => ['required', ],
            'award_winning' => ['nullable', 'sometimes', 'numeric'],
            'genres' => ['array', 'required', 'exists:genres,id'],
        ]);

        $movie = new Movie();
        $movie->name = $request->input('name');
        $movie->user_id = auth()->id() ?? 1;
        $movie->description = $request->input('description');
        $movie->image = $request->input('image');
        $movie->rating = $request->input('rating');
        $movie->release_date = $request->input('release_date');
        $movie->award_winning = (bool)((int)$request->input('award_winning'));
        $movie->save();

        $movie->genres()->sync($request->input('genres'));

        return response()->json(
            ['data' => $movie],
            SymfonyResponse::HTTP_OK
        );
    }
}
