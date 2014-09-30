<?php namespace NukaCode\Core\Http\Requests\Admin\Edit;

use Illuminate\Support\Facades\Auth;
use NukaCode\Core\Http\Requests\BaseRequest;

class Action extends BaseRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'roles' => 'array'
		];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return Auth::check() && Auth::user()->checkPermission('SITE_ADMIN');
	}

}
