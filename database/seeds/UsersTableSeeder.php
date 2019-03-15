<?php

use Illuminate\Database\Seeder;;
use Illuminate\Support\Facades\DB;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'login_name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10),
            'role' => '1',
            'full_name' => 'Administrator',
            'created_at' => now(),
        ]);
        factory(App\Models\User::class, 50)->create()->each(function ($user) {
            $user->profile()->save(factory(App\Models\UserProfile::class)->make());
            factory(App\Models\Story::class, rand(1, 4))->create([
                'user_id' => $user->id,
            ]);
            factory(App\Models\SaveList::class, rand(1, 4))->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
