<?php namespace App\Http\Repositories\V1\Admin;

use App\Http\Repositories\BaseRepository;
use App\Models\Theme;

class ThemeRepository extends BaseRepository
{
	public function __construct(Theme $theme)
	{
		$this->model =$theme;
	}

	public function index()
	{

		return $this->model->with('thematic')->get();
	}

	public function find($id)
	{
		return $this->model->findOrFail($id);
	}

	public function store($inputs)
	{
	  $theme = new $this->model;
	  $theme->fill($inputs);
	  $theme->save();
	}

	public function update($inputs, $id)
	{		
		$theme = $this->model->find($id);
		$theme->fill($inputs);
		$theme->save();
	}
	public function destroy($id)
	{
		$theme = $this->model->find($id);
		$theme->delete();
	}
}