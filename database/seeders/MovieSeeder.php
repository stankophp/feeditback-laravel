<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Movie::factory(5000)->create();
        for ($i =1; $i <= 5000; $i++) {
            DB::insert('insert into genre_movie (genre_id, movie_id) values (?, ?)', [rand(1,6), $i]);
        }
    }
}
