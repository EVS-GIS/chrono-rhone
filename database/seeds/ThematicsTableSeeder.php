<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Thematic;

class ThematicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('thematics')->delete();
        Thematic::create([
          'name_fr' => 'Divers',
          'name_en' => 'Various',
          'ranking' => 1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Thematic::create([
          'name_fr' => 'Usages et infrastructures',
          'name_en' => 'Uses and infrastructures',
          'ranking' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        
        
        Model::reguard();
    }
}