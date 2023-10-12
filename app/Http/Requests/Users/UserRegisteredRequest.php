<?php

namespace App\Http\Requests\Users;

use App\Dto\Users\UserRegisteredDto;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisteredRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->where(fn ( $query) => $query->where('email', $this->get('email'))->where('provider_id', 0))
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults()
            ],
        ];
    }

    public function getDto(): UserRegisteredDto
    {
        return new UserRegisteredDto(
            name: $this->get('name'),
            email: $this->get('email'),
            password: $this->get('password')
        );
    }
}
