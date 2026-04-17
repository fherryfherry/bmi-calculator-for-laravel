<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BmiCalculationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'weight' => ['required', 'numeric', 'min:20', 'max:300'],
            'height' => ['required', 'numeric', 'min:50', 'max:250'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name',
            'weight.required' => 'Please enter your weight',
            'weight.min' => 'Weight must be at least 20 kg',
            'weight.max' => 'Weight cannot exceed 300 kg',
            'height.required' => 'Please enter your height',
            'height.min' => 'Height must be at least 50 cm',
            'height.max' => 'Height cannot exceed 250 cm',
        ];
    }
}
