<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InitierPaiementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'client';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'creneau_id' => 'required|exists:creneaux,id',
            'date_heure' => 'required|date|after:now',
            'sujet'      => 'required|string|max:255',
            'methode'    => 'required|in:mobile_money,carte',
        ];
    }
}
