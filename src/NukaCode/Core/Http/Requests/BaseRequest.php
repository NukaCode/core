<?php namespace NukaCode\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use NukaCode\Support\Facades\Requests\Ajax;

abstract class BaseRequest extends FormRequest {

	/**
	 * Handle a failed validation attempt.
	 *
	 * @param  \Illuminate\Validation\Validator  $validator
	 * @return mixed
	 */
	protected function failedValidation(Validator $validator)
	{
		if ($this->ajax()) {
			Ajax::setStatus('error')->addErrors($validator->errors()->all());
		} else {
			parent::failedValidation($validator);
		}
	}

}