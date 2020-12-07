<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $fillable = [
      'id',
      'title_fr',
      'title_en',
      'creator',
      'start_year',
      'start_month',
      'start_day',
      'end_year',
      'end_month',
      'end_day',
      'description_fr',
      'description_en',
      'bibliography_fr',
      'bibliography_en',
      'km_up',
      'km_down',
      'theme_id',
      'user_id',
      'points',
      'lines',
      'polygons'
    ];
    protected $casts = ['km_up' => 'float','km_down' => 'float'];
    
    public function user()
    {
      return $this->belongsTo(User::class);
    }
    
    public function theme()
    {
      return $this->belongsTo(Theme::class);
    }

    public function images()
    {
      return $this->belongsToMany(Image::class);
    }

    public function from_events()
    {
      return $this->belongsToMany(Event::class,'events_relationships','to_event_id', 'from_event_id')->withPivot('relationship_id');
    }

    public function to_events()
    {
      return $this->belongsToMany(Event::class,'events_relationships','from_event_id', 'to_event_id')->withPivot('relationship_id');
    }
}