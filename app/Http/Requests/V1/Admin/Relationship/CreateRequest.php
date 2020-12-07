<?php 
namespace App\Http\Requests\V1\Admin\Relationship;

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
      'name_fr' => 'required|max:255|unique:relationships',
      'name_en' => 'required|max:255',
    ];
	}
}