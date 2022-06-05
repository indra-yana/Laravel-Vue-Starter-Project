<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Illuminate\Validation\ValidationException;
use Validator;

class UserValidator {

    /**
     * Validate when new data created.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateRegister(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'alpha_dash', 'min:3', 'max:10', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'avatar' => @$data["avatar"] ? ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:1000'] : '',
            // 'g-recaptcha-response' => 'recaptcha',
        ]);
    }
    
    /**
     * Validate when new data created.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateCreate(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'alpha_dash', 'min:3', 'max:10', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'avatar' => @$data["avatar"] ? ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:1000'] : '',
        ])->validate();
    }

    /**
     * Validate when data updated.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateUpdate(array $data)
    {
        return Validator::make($data, [
            'user_id' => ['required', 'string', 'uuid', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'alpha_dash', 'min:3', 'max:15', 'unique:users,username,'.$data["user_id"]],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$data["id"]],
            // 'password' => ['required', 'string', 'min:6', 'confirmed'],
            'avatar' => @$data["avatar"] ? ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:1000'] : '',
        ])->validate();
        
    }

    /**
     * Validate a model id.
     *
     * @param string $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateID(string $id)
    {
        return Validator::make(["id" => $id], [
            'id' => 'string|required|uuid|exists:users,id',
        ])->validate();
    }

    /**
     * Validate for change password.
     *
     * @param string $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateChangePassword(array $data)
    {
        return Validator::make($data, [
            'current_password' => 'required|equal_current_password',
            'password' => 'required|min:6|different:current_password|confirmed',
        ])->validate();
    }

}