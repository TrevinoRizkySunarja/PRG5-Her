<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCardRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only logged-in users can create/update cards
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'rarity' => ['required', 'string', 'in:Common,Rare,Legendary'],
            'description' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
