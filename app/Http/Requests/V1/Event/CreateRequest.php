<?php 
namespace App\Http\Requests\V1\Event;

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
      'title_fr' => 'required|max:255|unique:events',
      'start_year' => 'required|integer',
      'theme.id' => 'required|integer',
      'author_id' => 'required|integer'
    ];
	}
}