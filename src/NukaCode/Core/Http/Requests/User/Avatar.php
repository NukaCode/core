<?php namespace NukaCode\Core\Http\Requests\User;

use Illuminate\Support\Facades\Auth;
use NukaCode\Core\Http\Requests\BaseRequest;

class Avatar extends BaseRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'avatar_preference_id' => 'required',
			'avatar_preference'    => 'required'
		];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return Auth::check();
	}

}
