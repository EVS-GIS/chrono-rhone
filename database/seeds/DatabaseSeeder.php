<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call(RolesTableSeeder::class);
      $this->call(UsersTableSeeder::class);
      //$this->call(ThematicsTableSeeder::class);
      //$this->call(ThemesTableSeeder::class);
      //$this->call(EventsTableSeeder::class);
      //$this->call(RelationshipsTableSeeder::class);
      //$this->call(EventsRelationshipsTableSeeder::class);
    }
}
