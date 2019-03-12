<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-03-11
 * Time: 18:51
 */

namespace App\Http\Requests;

class CertificationRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'longitude' => [
                'float',
                'required'
            ],
            'latitude' => [
                'float',
                'required'
            ],
            'address' => [
                'string',
                'required'
            ],
            'terminal' => [
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