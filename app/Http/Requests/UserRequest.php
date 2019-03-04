<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-18
 * Time: 20:53
 */

namespace App\Http\Requests;


class UserRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => [
                'bail',
                'required',
                'string',
                'max:'.config('project.user.name.max_length'),
            ],
            'email' => [
                'bail',
                'required',
                'email',
                'max:'.config('project.user.email.max_length'),
            ],
            'password' => [
                'bail',
                'required',
                'min:'.config('project.user.password.min_length'),
                'max:'.config('project.user.password.max_length'),
                'confirmed',
            ],
        ];

        return $rules;
    }
}