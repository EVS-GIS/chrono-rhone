<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Eventrelationship;

class EventsRelationshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('events_relationships')->delete();
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 1,
          'to_event_id' => 5
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 2,
          'to_event_id' => 3
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 4,
          'to_event_id' => 6
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 5,
          'to_event_id' => 4
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 6,
          'to_event_id' => 12
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 8,
          'to_event_id' => 6
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 8,
          'to_event_id' => 9
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 8,
          'to_event_id' => 10
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 8,
          'to_event_id' => 11
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 13,
          'to_event_id' => 18
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 14,
          'to_event_id' => 7
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 1,
          'to_event_id' => 2
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 18,
          'to_event_id' => 14
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 18,
          'to_event_id' => 15
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 18,
          'to_event_id' => 16
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 18,
          'to_event_id' => 17
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 19,
          'to_event_id' => 20
        ]);
        Eventrelationship::create([
          'relationship_id' => 1,
          'from_event_id' => 20,
          'to_event_id' => 21
        ]);        
        Model::reguard();
    }
}