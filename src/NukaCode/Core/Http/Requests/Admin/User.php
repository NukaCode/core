<?php namespace NukaCode\Core\Http\Requests\Admin;

use Illuminate\Support\Facades\Auth;
use NukaCode\Core\Http\Requests\BaseRequest;

class Theme extends BaseRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'style'   => 'required',
			'src'     => 'required',
			'gray'    => 'required',
			'primary' => 'required',
			'info'    => 'required',
			'success' => 'required',
			'warning' => 'required',
			'danger'  => 'required',
			'menu'    => 'required',
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
