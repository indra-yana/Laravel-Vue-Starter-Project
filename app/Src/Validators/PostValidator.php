<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Illuminate\Validation\ValidationException;
use Validator;

class PostValidator {

    /**
     * Validate when new data created.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateCreate(array $data)
    {
        return Validator::make($data, [
            'user_id' => 'string|required|exists:users,id',
            'title' => 'string|required|max:255',
            'body' => 'string|nullable',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2000',
            'status' => 'numeric|nullable|in:0,1',
            'is_pinned' => 'numeric|nullable|in:0,1',
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
            'id' => 'required|string|exists:posts,id',
            'title' => 'string|required|max:255',
            'body' => 'string|nullable',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2000',
            'status' => 'numeric|nullable|in:0,1',
            'is_pinned' => 'numeric|nullable|in:0,1',
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
            'id' => 'string|required|exists:posts,id',
        ])->validate();
    }

}