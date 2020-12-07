<?php namespace App\Http\Repositories\V1\Admin;

use App\Http\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DeleteUser;
use App\Models\User;

class UserRepository extends BaseRepository
{
	public function __construct(User $user)
	{
		$this->model = $user;
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
		$user = new $this->model;
		$user->firstname = $inputs['firstname'];
		$user->name = $inputs['name'];
		$user->organization = $inputs['organization'];
    $user->email = $inputs['email'];
		if(isset($inputs['password'])){
	    $user->password = bcrypt($inputs['password']);
	  }
	  if(isset($inputs['role'])){
	    $user->role_id = $inputs['role'];
	  }
		$user->save();
	}

	public function update($inputs, $id)
	{		
    $user = $this->model->find($id);
    $user->firstname = $inputs['firstname'];
		$user->name = $inputs['name'];
		$user->organization = $inputs['organization'];
    $user->email = $inputs['email'];
		if(isset($inputs['password'])){
	    	$user->password = bcrypt($inputs['password']);
		}
		if(isset($inputs['role']) && Auth::user()->isAdmin()){
	    $user->role_id = $inputs['role'];
	  }
		$user->save();
	}
  
  public function destroy($id)
	{
    $user = $this->model->find($id);
    $admins = $this->model->whereHas('role', function($q){ $q->where('slug','admin'); })->get();
    Notification::send($admins, new DeleteUser($user));
    $user->delete();
	}
}