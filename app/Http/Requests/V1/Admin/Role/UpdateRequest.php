<?php 
namespace App\Http\Requests\V1\Admin\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$id = $this->role;
    	return $rules = [
			'slug' => 'required|max:30|unique:roles,slug,'.$id,
      'name' => 'required|max:255,name,'.$id
		];
	}
}