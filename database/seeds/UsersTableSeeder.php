<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('users')->delete();
        User::create([
          'firstname' => 'Fanny',
          'name' => 'Arnaud',
          'organization' => 'ENS de Lyon',
          'email' => 'admin@chrono-rhone.fr',
          'password' => bcrypt('admin'),
          'role_id' => 1
        ]);
        Model::reguard();
    }
}