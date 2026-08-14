<?php

namespace App\Modules\SuperAdministrator\DoctorAccounts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => ['required_without:email', 'string', 'max:255'],
            'email' => [
                'required_without:name',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->route('doctor')),
            ],
        ];
    }
}
