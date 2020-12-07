<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Theme;

class ThemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('themes')->delete();
        Theme::create([
          'name_fr' => 'Contexte socio-économique et politique',
          'name_en' => 'Socio-economic and political context',
          'ranking' => 1,
          "color" => '#045a8d',
          'thematic_id' => 1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Theme::create([
          'name_fr' => 'Législation',
          'name_en' => 'Legislation',
          'ranking' => 2,
          "color" => '#2b8cbe',
          'thematic_id' => 1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Theme::create([
          'name_fr' => 'Trajectoire biologique',
          'name_en' => 'Biological trajectory',
          'ranking' => 3,
          "color" => '#74a9cf',
          'thematic_id' => 1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Theme::create([
          'name_fr' => 'Trajectoire morphologique',
          'name_en' => 'Morphological trajectory',
          'ranking' => 4,
          "color" => '#a6bddb',
          'thematic_id' => 1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Theme::create([
          'name_fr' => 'Evènements hydro-climatiques',
          'name_en' => 'Hydro-climatic events',
          'ranking' => 5,
          "color" => '#d0d1e6',
          'thematic_id' => 1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Theme::create([
          'name_fr' => 'Structures administratives et organismes de gestion',
          'name_en' => 'Administrative structures and management bodies',
          'ranking' => 6,
          "color" => '#f1eef6',
          'thematic_id' => 1,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Theme::create([
          'name_fr' => 'Protection contre les crues',
          'name_en' => 'Flood protection',
          'ranking' => 7,
          "color" => '#f03b20',
          'thematic_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Theme::create([
          'name_fr' => 'Navigation',
          'name_en' => 'Navigation',
          'ranking' => 8,
          "color" => '#feb24c',
          'thematic_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Theme::create([
          'name_fr' => 'Hydro-électricité',
          'name_en' => 'Hydro-electricity',
          'ranking' => 9,
          "color" => '#ffeda0',
          'thematic_id' => 2,
          'created_at' => date("Y-m-d H:i:s"),
          'updated_at' => date("Y-m-d H:i:s")
        ]);
        Model::reguard();
    }
}