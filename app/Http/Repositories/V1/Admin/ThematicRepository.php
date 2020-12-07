<?php namespace App\Http\Repositories\V1\Admin;

use App\Http\Repositories\BaseRepository;
use App\Models\Thematic, App\Models\Theme;

class ThematicRepository extends BaseRepository
{
	public function __construct(Thematic $thematic)
	{
		$this->model =$thematic;
	}

	public function index()
	{

		return $this->model->with('themes')->get();
	}

	public function find($id)
	{
		return $this->model->findOrFail($id);
	}

	public function store($inputs)
	{
	  $thematic = new $this->model;
    $thematic->fill($inputs);
    $thematic->save();
    if($inputs['themes']){
      foreach($inputs['themes'] as $id){
        $theme = Theme::findOrFail($id);
        $theme->thematic_id = $thematic->id;
        $theme->save();
      }
    }    
	}

	public function update($inputs, $id)
	{		
		$thematic = $this->model->find($id);
    $thematic->fill($inputs);
    $thematic->save();
    if($inputs['themes']){
      $themes_id=[];
      foreach($thematic->themes as $object){
        $themes_id[] = $object->id;
      }
      foreach(array_unique(array_merge($inputs['themes'],$themes_id)) as $id){
        $theme = Theme::findOrFail($id);
        if(in_array($id,$inputs['themes'])){
          $theme->thematic_id = $thematic->id;
        }else{
          $theme->thematic_id = null;
        }
        $theme->save();
      }     
    }
	}
	public function destroy($id)
	{
		$thematic = $this->model->find($id);
		$thematic->delete();
	}
}