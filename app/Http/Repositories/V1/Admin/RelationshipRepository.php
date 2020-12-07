<?php namespace App\Http\Repositories\V1\Admin;

use App\Http\Repositories\BaseRepository;
use App\Models\Relationship;

class RelationshipRepository extends BaseRepository
{
	public function __construct(Relationship $relationship)
	{
		$this->model =$relationship;
	}

	public function index()
	{

		return $this->model->get();
	}

	public function find($id)
	{
		return $this->model->findOrFail($id);
	}

	public function store($inputs)
	{
	  $relationship = new $this->model;
	  $relationship->fill($inputs);
	  $relationship->save();
	}

	public function update($inputs, $id)
	{		
		$relationship = $this->model->find($id);
		$relationship->fill($inputs);
		$relationship->save();
	}
	public function destroy($id)
	{
		$relationship = $this->model->find($id);
		$relationship->delete();
	}
}