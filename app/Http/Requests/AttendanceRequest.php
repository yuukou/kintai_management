<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2019/01/17
 * Time: 17:38
 */

namespace App\Http\Requests;

class AttendanceRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'attendance' => [
                'string',
                'required'
            ]
        ];

        return $rules;
    }

    /**
     * Set custom attributes for validator errors.
     *
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function attributes()
    {
        return trans('form.attributes');
    }
}