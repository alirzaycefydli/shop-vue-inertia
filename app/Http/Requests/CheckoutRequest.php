<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class CheckoutRequest extends FormRequest
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
            // Address
            'address.type' => [
                'required',
                Rule::in(['new', 'saved']),
            ],

            'address.id' => [
                'required_if:address.type,saved',
                'nullable',
                'uuid',
            ],

            'address.user_id' => [
                'nullable',
                'uuid',
                'exists:users,id',
            ],

            'address.alias' => [
                'nullable',
                'string',
                'max:100',
            ],

            'address.name' => [
                'required_if:address.type,new',
                'string',
                'max:255',
            ],

            'address.address' => [
                'required_if:address.type,new',
                'string',
                'max:255',
            ],

            'address.city' => [
                'required_if:address.type,new',
                'string',
                'max:100',
            ],

            'address.postal_code' => [
                'required_if:address.type,new',
                'string',
                'max:20',
            ],

            'address.country' => [
                'required_if:address.type,new',
                'string',
                'max:100',
            ],

            'address.save_address' => [
                'sometimes',
                'boolean',
            ],

            // Cart items
            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*' => [
                'required',
                'array',
            ],

            'items.*.id' => [
                'required',
                'uuid',
                'distinct',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }
}
