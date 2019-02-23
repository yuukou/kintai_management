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
                'bail',
                'string',
                'max:'.config('project.user.name.max_length'),
            ],
            'email' => [
                'bail',
                'required',
                'email',
                'max:'.config('project.user.email.max_length'),
            ],
        ];

        return $rules;
    }
}