<?php

namespace Database\Seeders;

use App\Models\User;
use App\Src\Base\Constant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class UserSeeder extends Seeder
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

            // Truncate the table first to seed fresh data
            User::truncateModel();
            for ($i=1; $i <= Constant::SEEDER_LIMIT; $i++) {
                User::create([
                    'name' => $name = $faker->name,
                    'username' => "usertest$i",
                    'email' => strtolower(explode(" ", $name)[0]) ."$i@$faker->freeEmailDomain",
                    'email_verified_at' => now(),
                    'password' => bcrypt('secret'),
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
