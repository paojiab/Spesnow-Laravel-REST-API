<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Request;

class SubscriptionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        return $user->tokenCan('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if (Request::isMethod('patch')) {
            return [
                'title' => 'sometimes|required|unique:adverts,title|max:255',
                'price' => 'sometimes|required|numeric',
                'timeframe' => ['sometimes', 'required', Rule::in(['week', 'month', 'quarter'])],
                'desc' => 'sometimes|nullable'
            ];
        }

        return [
            'title' => 'required|unique:adverts,title|max:255',
            'price' => 'required|numeric',
            'timeframe' => ['required', Rule::in(['week', 'month', 'quarter'])],
            'desc' => 'nullable'
        ];
    }
}
