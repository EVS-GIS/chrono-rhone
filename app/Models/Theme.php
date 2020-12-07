<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table = 'themes';
    protected $fillable = ['name_fr','name_en','ranking','color','thematic_id'];
    
    public function events()
    {
      return $this->hasMany(Event::class);
    }

    public function thematic()
    {
      return $this->belongsTo(Thematic::class);
    }
}