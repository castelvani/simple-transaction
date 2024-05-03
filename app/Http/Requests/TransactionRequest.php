<?php

namespace App\Http\Requests;

use App\Rules\ExistingCommonUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'value' => ['required', 'numeric'],
            'payer' => [
                'required',
                new ExistingCommonUser
            ],
            'payee' => [
                'required',
                Rule::exists('users', 'id'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'value.required' => 'The value field is required.',
            'value.numeric' => 'The value must be a number.',
            'payer.required' => 'The payer field is required.',
            'payer.existing_common_user' => 'The selected payer is invalid.', // Custom message for ExistingCommonUser rule
            'payee.required' => 'The payee field is required.',
            'payee.exists' => 'The selected payee is invalid.',
        ];
    }
}
