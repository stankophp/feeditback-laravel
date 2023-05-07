<?php

namespace App\Filters;

use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;

class MovieFilter extends Filters
{
    protected $filters = ['name', 'release_date', 'actors', 'genres',];

    /**
     * Filter the movies by name
     * @param $name
     * @return mixed
     */
    protected function name($name)
    {
        $movie = Movie::whereName($name)->first();
        return $this->builder->where('id', $movie->id);
    }

    /**
     * Filter the movies by release_date
     * @param $date
     * @return mixed
     */
    protected function release_date($date)
    {
        return $this->builder->where('release_date', $date);
    }

    /**
     * Filter the movies by actors
     * @param $name
     * @return mixed
     */
    protected function actors($name)
    {
        /** @var Actor $actor */
        $actor = Actor::whereName($name)->first();

        $actor->load('movies');
        $ids = [];
        foreach ($actor->movies as $movie) {
            $ids[] = $movie->id;
        }

        return $this->builder->orWhereIn('id', $ids);
    }

    /**
     * Filter the movies by genres
     * @param $name
     * @return mixed
     */
    protected function genres($name)
    {
        /** @var Genre $genre */
        $genre = Genre::whereName($name)->first();

        $genre->load('movies');
        $ids = [];
        foreach ($genre->movies as $movie) {
            $ids[] = $movie->id;
        }
        return $this->builder->orWhereIn('id', $ids);
    }
}
