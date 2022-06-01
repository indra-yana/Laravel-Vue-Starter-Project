<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Src\Base\Constant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();

            $faker = Factory::create('id_ID');
            $user = User::get()->pluck('id');

            // Truncate the table first to seed fresh data
            Post::truncateModel();
            for ($i=0; $i < Constant::SEEDER_LIMIT; $i++) {
                Post::create([
                    'title' => $faker->sentence(5, true),
                    'body' => $faker->sentence(50, true),
                    'thumbnail' => 'sample-img-1.jpg',
                    'user_id' => $user[$i],
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
