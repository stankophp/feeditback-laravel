<?php

namespace Database\Seeders;

use App\Models\Actor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Actor::factory(50)->create();
        for ($i = 1; $i <= 50; $i++) {
            for ($j = 0; $j < 5; $j++) {
                DB::insert('insert into actor_movie (movie_id, actor_id) values (?, ?)', [rand(1, 5000), $i]);
            }
        }
    }
}
