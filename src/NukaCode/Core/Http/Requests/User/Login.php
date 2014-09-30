<?php namespace NukaCode\Core\Http\Requests\User;

use Illuminate\Support\Facades\Auth;
use NukaCode\Core\Http\Requests\BaseRequest;

class Login extends BaseRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'username' => 'required',
			'password' => 'required'
		];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return Auth::guest();
	}

}
