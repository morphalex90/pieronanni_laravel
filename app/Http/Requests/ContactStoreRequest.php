<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\Recaptcha;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ContactStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email'],
            'message' => ['required', 'string', 'max:1000'],
            'privacy' => ['accepted'],
            'recaptcha_token' => [
                Rule::requiredIf(fn (): bool => filled(config('services.recaptcha.secret'))),
                'string',
                new Recaptcha('contact'),
            ],
        ];
    }
}
