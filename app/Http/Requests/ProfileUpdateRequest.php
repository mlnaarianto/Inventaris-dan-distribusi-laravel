<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name'       => ['required', 'string', 'max:255'],
            'foto'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'hapus_foto' => ['nullable', 'boolean'],
        ];

        if ($this->user()->can('profile.update-email')) {
            $rules['email'] = [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ];
        }

        if ($this->user()->can('profile.update-username')) {
            $rules['username'] = [
                'required', 'string', 'lowercase', 'alpha_dash', 'min:3', 'max:50',
                Rule::unique(User::class)->ignore($this->user()->id),
            ];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'name'     => 'nama',
            'email'    => 'email',
            'username' => 'username',
            'foto'     => 'foto profil',
        ];
    }
}