<?php 
namespace App\Http\Requests\V1\Event;

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
		$id = $this->event;
    	return $rules = [
      'title_fr' => 'required|max:255,title_fr,'.$id,
      'start_year' => 'required|integer',
      'theme.id' => 'required|integer',
      'author_id' => 'required|integer'
		];
	}
}