<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class SocialLinkValidator {

    /**
     * Validate when new data created.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateCreate(array $data)
    {
        $socialLink = $data['social_links'];
        $validation = [];
        foreach ($socialLink as $key => $value) {
            $validation[$key] = 'nullable|string|min:3|alpha_dash_dot';
            $data[$key] = $value['link'];
        }

        return Validator::make($data, array_merge([
            'user_id' => 'string|required|uuid|exists:users,id',
            'social_links' => 'required|array',
            // 'social_links.*.link' => 'nullable|string|min:3|alpha_dash_dot',
        ], $validation))->validate();
    }

    /**
     * Validate a model id.
     *
     * @param string $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateUserID(string $id)
    {
        return Validator::make(["user_id" => $id], [
            'user_id' => 'string|required|uuid|exists:users,id',
        ])->validate();
    }

}