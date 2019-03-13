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
            // 緯度
            'latitude' => [
                'required',
                'numeric',
                'regex:/^[-]?((([0-8]?[0-9])(\.[0-9]{6}))|90(\.0{6})?)$/'
            ],
            // 経度
            'longitude' => [
                'required',
                'numeric',
                'regex:/^[-]?(((([1][0-7][0-9])|([0-9]?[0-9]))(\.[0-9]{6}))|180(\.0{6})?)$/'
            ],
            //住所
            'address' => [
                'string',
                'required'
            ],
            //端末情報
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