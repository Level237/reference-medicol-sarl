<?php

namespace App\Http\Requests\Admin;

use App\Models\QuoteRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuoteStatusRequest extends FormRequest
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
            'status' => [
                'required',
                'string',
                Rule::in([
                    QuoteRequest::STATUS_PENDING,
                    QuoteRequest::STATUS_PROCESSING,
                    QuoteRequest::STATUS_PROCESSED,
                    QuoteRequest::STATUS_REJECTED,
                ]),
            ],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
