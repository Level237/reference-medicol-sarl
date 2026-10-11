<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'organization_name' => ['required', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'organization_name.required' => 'Indiquez le nom de l\'établissement.',
            'contact_name.required' => 'Indiquez votre nom.',
            'phone.required' => 'Indiquez un numéro de téléphone.',
            'email.required' => 'Indiquez une adresse e-mail.',
            'email.email' => 'Cette adresse e-mail n\'est pas valide.',
            'message.required' => 'Précisez votre demande.',
        ];
    }
}
