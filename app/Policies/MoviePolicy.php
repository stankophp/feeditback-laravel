<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Movie;
use Illuminate\Auth\Access\HandlesAuthorization;

class MoviePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can update the thread.
     *
     * @param  User  $user
     * @param  Movie  $movie
     * @return bool
     */
    public function update(User $user, Movie $movie)
    {
        return $movie->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the thread.
     *
     * @param  User  $user
     * @param  Movie  $movie
     * @return bool
     */
    public function delete(User $user, Movie $movie)
    {
        return $movie->user_id === $user->id;
    }
}
