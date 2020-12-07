<?php 
namespace App\Http\Requests\V1\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest {

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
		return [
      'firstname' => 'required|max:255',
      'name' => 'required|max:255',
      'organization' => 'required|max:255',
      'email' => 'required|email|unique:users',
      'password' => 'required|string|min:8|confirmed',
      'role' => 'required|integer'
    ];
	}
}