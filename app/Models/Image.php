<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = ['filename','legend_fr','legend_en','copyright'];

  public function events()
	{
	  return $this->belongsToMany(Event::class);
	}
}