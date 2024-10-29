<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowMoreRequest extends FormRequest
{
	public function rules()
	{
		return [
			'page' => 'required|integer|min:1',
		];
	}

	public function authorize()
	{
		return true;
	}
}
