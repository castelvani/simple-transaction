<?php

namespace App\Http\Requests;

use App\Enums\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRegisterRequest extends FormRequest
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
            'name'     => ['required', 'string'],
            'email'    => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
            'cpf'      => ['nullable', 'required_if:type,' . UserTypeEnum::Common->value, Rule::unique('users', 'cpf'), 'string'],
            'cnpj'     => ['nullable', 'required_if:type,' . UserTypeEnum::Merchant->value, Rule::unique('users', 'cnpj'), 'string'],
            'type'     => ['required', Rule::in([UserTypeEnum::Common->value, UserTypeEnum::Merchant->value])],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'The email has already been taken.',
            'email.email' => 'The email must be a valid email address.',
            'password.required' => 'The password field is required.',
            'cpf.required_if' => 'The CPF field is required when the type is Common.',
            'cpf.unique' => 'The CPF has already been taken.',
            'cnpj.required_if' => 'The CNPJ field is required when the type is Merchant.',
            'cnpj.unique' => 'The CNPJ has already been taken.',
            'type.required' => 'The type field is required.',
            'type.in' => 'The type must be either Common or Merchant.',
        ];
    }
}
