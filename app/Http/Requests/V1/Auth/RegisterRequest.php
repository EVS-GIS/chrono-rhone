<?php
namespace App\Http\Requests\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
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
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255|unique:users',
            'organization' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ];
    }
}
