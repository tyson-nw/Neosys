<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $first = User::factory()->create([
            'id' => 1,
            "name"=>env('INITIAL_USER_NAME'),
            "email"=> env('INITIAL_USER_EMAIL'),
            "email_verified_at"=> now(),
            "password"=>  env('INITIAL_USER_PASSWORDHASH'),
            "created_at"=> now(),
            "updated_at"=> now(),
        ]);
        $first->assign('admin');
    }
}
