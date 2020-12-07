<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thematic extends Model
{
    protected $table = 'thematics';
    protected $fillable = ['name_fr','name_en','ranking'];
    
    public function themes()
    {
      return $this->hasMany(Theme::class);
    }

    public function events()
    {
      return $this->hasManyThrough(Event::class, Theme::class,'thematic_id','theme_id','id', 'id');
    }
}