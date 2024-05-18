<?php

namespace Bunitech\DrawErd\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RunCommandsRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules()
    {
        return [
            'commands' => 'required|array',
            'commands.*' => Rule::in(['migrate', 'migrate:fresh', 'migrate:fresh --seed'])
        ];
    }
}
