<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    protected $table = 'relationships';
    protected $fillable = ['name_fr','name_en'];
    
    public function events_relationships()
    {
      return $this->hasMany(EventRelationship::class);
    }
}