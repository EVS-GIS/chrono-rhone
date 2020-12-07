<?php 
namespace App\Http\Requests\V1\Admin\Theme;

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
      'name_fr' => 'required|max:255|unique:themes',
      'name_en' => 'required|max:255',
      'ranking' => 'required|integer|unique:themes',
      'color' => 'required|max:255',
      'thematic_id' => 'required|integer'
    ];
	}
}