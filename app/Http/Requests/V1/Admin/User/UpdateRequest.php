<?php 
namespace App\Http\Requests\V1\Admin\User;

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
		$id = $this->user;
    	return $rules = [
      'firstname' => 'required|max:255,firstname,'.$id, 
      'name' => 'required|max:255,name,'.$id, 
      'email' => 'required',
			'organization' => 'required|max:255,organization,'.$id
			
		];
	}
}