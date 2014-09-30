<?php namespace NukaCode\Core\Http\Requests\User;

use Illuminate\Support\Facades\Auth;
use NukaCode\Core\Http\Requests\BaseRequest;

class UploadAvatar extends BaseRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'avatar' => 'required|image',
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
