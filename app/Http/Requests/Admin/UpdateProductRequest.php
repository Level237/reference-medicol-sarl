<?php

namespace App\Http\Requests\Admin;

class UpdateProductRequest extends ProductFormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            ...$this->baseRules(),
            ...$this->galleryRules(),
        ];
    }
}
