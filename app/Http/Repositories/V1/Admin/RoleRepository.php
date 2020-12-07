<?php namespace App\Http\Repositories\V1\Admin;

use App\Http\Repositories\BaseRepository;
use App\Models\Role;

class RoleRepository extends BaseRepository
{
	public function __construct(Role $role)
	{
		$this->model = $role;
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
	    $role = new $this->model;
	    $role->fill($inputs);
	    $role->save();
	}

	public function update($inputs, $id)
	{		
		$role = $this->model->find($id);
		$role->fill($inputs);
		$role->save();
	}
	public function destroy($id)
	{
		$role = $this->model->find($id);
		$role->delete();
	}
}