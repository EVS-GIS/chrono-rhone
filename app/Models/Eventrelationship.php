<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eventrelationship extends Model
{
    protected $table = 'events_relationships';
    protected $fillable = ['relationship_id','from_event_id', 'to_event_id'];

    public $timestamps = false;
    
    public function relationship()
    {
      return $this->belongsTo(Relationship::class);
    }
}